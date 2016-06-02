@extends('admin.template.template')

@section('title', '用户关系 - 魔豆树')

@section('header', '用户关系')

@section('content')
    <div id="jstree_demo_div" style="font-size: 150%;">
    </div>
@endsection

@section('moreScript')
    <script src="{{ asset('assets') }}/js/jstree.min.js"></script>
    <script>
        $(function () {
            var data = {};
//            $.ajax({
//                url: ADMIN + '/ajax/user/relation',
//                type: 'post',
//                async: false,
//                success: function (q) {
//                    data = q['data'];
//                }
//            });
            $('#jstree_demo_div').jstree({
                'core' : {
                    'data': {
                        'url': function(node) {
                            if(node.id === '#') {
                                return ADMIN + '/ajax/user/relation/get/root';
                            } else {
                                return ADMIN + '/ajax/user/relation';
                            }
                        },
                        'data': function (node) {
                            return {
                                id: node.id,
                                parent: node.parent,
                                text: node.text
                            };
                        }
                    }
                }
            });
        });
    </script>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets/css/jstree.min.css') }}"/>
@endsection