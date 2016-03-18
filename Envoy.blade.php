@setup
    $serverPath = '/var/www/modelo';
    $localPath = getcwd();
    $ssh = 'root@115.28.229.14';
@endsetup

@servers(['web' => 'root@115.28.229.14' ])

@task('deploy', ['on' => 'web'])
    cd {{ $serverPath }}
    [ -f {{ $localPath }}/.env.production ] && scp {{ $localPath }}/.env.production {{ $ssh }}:{{ $serverPath }}/.env
    git pull origin
    composer update
    composer dump-autoload --optimize
@endtask