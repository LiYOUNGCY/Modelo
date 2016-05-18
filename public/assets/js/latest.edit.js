/**
 * Created by rache on 2016/4/24.
 */

function Container() {
    this.data = {};
}

Container.prototype.put = function () {
    switch (arguments.length) {
        case 1:
            var obj = arguments[0];
            for (var p in obj) {
                if (typeof p != 'function') {
                    this.data[p] = obj[p];
                }
            }
            break;
        case 2:
            var key = arguments[0];
            var value = arguments[1];
            this.data[key] = value;
            break;
        default:
            return 0;
    }
};

Container.prototype.get = function (key) {
    return this.data[key];
};

function Column(data) {
    this.container = new Container();
    this.container.put({
        'size': 6,
        'offset': 0,
        'type': 1
    });

    this.container.put(data);

    this.create();
}

Column.prototype.delete = function () {

};

Column.prototype.create = function () {
    var col = '';
    var offset = this.container.get('offset');
    var size = this.container.get('size');

    if (offset == 0) {
        col += '<div class="col col-md-' + size + '">' + this.getByType() + '</div>';
    }
    else {
        col += '<div class="col col-md-offset-' + offset + ' col-md-' + size + '">' + this.getByType() + '</div>';
    }

    this.$container = $(col);
};

Column.prototype.getByType = function () {
    var type = this.container.get('type');
    type = parseInt(type);
    var content = this.container.get('content');

    switch (type) {
        case 1:
            return '<img src="' + BASEURL + content + '">';
            break;
        case 2:
            return '<a href="' + content + '">链接</a>';
            break;
        default:
            break;
    }

    return '';
};

Column.prototype.getColumn = function () {
    return this.$container;
};

Column.prototype.getData = function () {
    return {
        'col': this.container.get('id'),
        'row': this.container.get('row'),
        'size': this.container.get('size'),
        'type': this.container.get('type'),
        'offset': this.container.get('offset'),
        'content': this.container.get('content'),
        'name': this.container.get('name')
    }
};


function Row(data) {
    this.container = new Container();
    this.container.put(data);
    this.container.put('column', {});

    var rowId = this.container.get('id');
    this.$container = $('<div class="row" data-id="' + rowId + '"></div>');
    this.setMaxColumn(1);
}


Row.prototype.createIn = function ($container) {
    var $btn = $('<div class="create-col" id="test">' +
        '<a class="fa fa-plus-square-o" style="font-size: 7em;" href="#"></a>' +
        '</div>');

    this.$container.append($btn);

    $btn.find('a').click(function () {
        $('#myModal').modal('show');
        var rowId = $(this).parent().parent().attr('data-id');
        Wrapper.setSource(rowId);
    });

    $container.append(this.$container);
    // data-toggle="modal" data-target="#myModal"

};

Row.prototype.getContainer = function () {
    return this.$container;
};

Row.prototype.insertColumn = function (data) {
    data['id'] = this.getMaxColumn();
    data['row'] = this.container.get('id');
    if(data.type == 2) {
        data['name'] = data['content'].split(',')[1];
    } else if(data.type == 1) {
        data['name'] = data.url;
        console.log(data['name']);
    }
    data['content'] = data['content'].split(',')[0];
    var col = new Column(data);
    var tar = this.$container.find('.create-col')[0];

    var columns = this.container.get('column');
    columns[this.getMaxColumn()] = col;
    $(col.getColumn()).insertBefore($(tar));
    this.setMaxColumn(this.getMaxColumn() + 1);
};

Row.prototype.getMaxColumn = function () {
    return this.maxColumn;
};

Row.prototype.setMaxColumn = function (maxColumn) {
    this.maxColumn = maxColumn;
};

function Wrapper($container) {
    this.container = new Container();
    this.container.put('row', {});
    this.$container = $container;

    Wrapper.setMaxRow(1);
}

Wrapper.prototype.createRow = function () {
    var rows = this.container.get('row');
    var rowId = Wrapper.getMaxRow();
    var row = new Row({
        'id': rowId
    });
    Wrapper.setMaxRow(Wrapper.getMaxRow() + 1);

    row.createIn(this.$container);
    rows[rowId] = row;
};

Wrapper.prototype.submit = function () {
    $.ajax({
        url: ADMIN + 'latest/destroy',
        async: false
    });
    var rows = this.container.get('row');
    // console.log(rows);
    for (var i in rows) {
        var row = rows[i];
        var columns = row.container.get('column');
        for (var j in columns) {
            var data = columns[j].getData();

            $.ajax({
                async: false,
                url: ADMIN + 'latest/store',
                data: data,
                success: function (data) {
                    console.log(data);
                }
            });
        }
    }
};

Wrapper.setSource = function (source) {
    this.source = source;
};

Wrapper.getSource = function () {
    return this.source;
};

Wrapper.getMaxRow = function () {
    return this.maxRow;
};

Wrapper.setMaxRow = function (maxRow) {
    this.maxRow = maxRow;
};

Wrapper.prototype.createColumn = function (data) {
    var rowId = Wrapper.getSource();

    var rows = this.container.get('row');
    var row = rows[rowId];

    row.insertColumn(data);
};
