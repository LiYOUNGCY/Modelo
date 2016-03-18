 <?php require_once('envoy.config.php'); ?>;
<?php
    if ( ! isset($appname) ) {
        throw new Exception('App Name is not set');
    }
    if ( ! isset($ssh) ) {
        throw new Exception('SSH login username/host is not set');
    }
    if ( ! isset($repo) ) {
        throw new Exception('Git repository is not set');
    }

    if ( ! isset($serviceowner) ) {
        throw new Exception('Service Owner is not set');
    }
    if ( ! isset($deploybasepath) ) {
        throw new Exception('Path is not set');
    }
    if ( substr($deploybasepath, 0, 1) !== '/' ) {
        throw new Exception('Careful - your path does not begin with /');
    }
    $now = new DateTime();
    $dateDisplay = $now->format('Y-m-d H:i:s');
    $date = $now->format('YmdHis');
    $env = isset($env) ? $env : "production";
    $branch = isset($branch) ? $branch : "master";
    $deploybasepath = rtrim($deploybasepath, '/');
    $app_base = $deploybasepath.'/'.$appname;
    $release_dir = $app_base.'/releases';
    $app_dir = $app_base.'/current';
    $prev_dir = $app_base.'/prevrelease';
    $last_dir = $app_base.'/lastrelease';
    $shared_dir = $app_base.'/shared';
    $release = isset($release) ? $release :'release_' . date('YmdHis');
    $local_dir = getcwd();
    $local_envoydeploy_dirname = '.envoydeploy';
    $local_envoydeploy_base = $local_dir.'/'.$local_envoydeploy_dirname;
?>
<?php $__container->servers(['local'=>'localhost','web' => $ssh]); ?>
<?php $__container->startMacro('help'); ?>
    showcmdlist
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('deploy'); ?>
    <?php /*deploy_localrepo_pack*/ ?>
    show_env
    init_basedir_local
    fetch_repo_localrepo
    copy_env_localrepo
    pack_deps_local
    chdir_localrepo
    deps_extract_localrepo
    copy_custom_extra_localrepo
    artisan_optimize_localrepo
    pack_release_localrepo
    init_basedir_remote
    scp_release_to_remote
    extract_release_on_remote
    sync_shared
    update_permissions
    envfile_link
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    cleanup_tempfiles_local
    cleanup_tempfiles_remote
    notice_done
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('manscprelease'); ?>
    scp_release_to_remote
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('mandeployrelease'); ?>
    <?php /* man scp release.tgz to [deploy_base]/[app]/tmp/ */ ?>
    <?php /*man scp  & deploy_localrepo_pack*/ ?>
    show_env
    init_basedir_local
    extract_release_on_remote
    sync_shared
    update_permissions
    envfile_link
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    cleanup_tempfiles_local
    cleanup_tempfiles_remote
    notice_done
<?php $__container->endMacro(); ?>

<?php $__container->startMacro('deploy_mix_pack', ['on' => 'local']); ?>
    <?php /*deploy_mix_pack*/ ?>
    show_env
    init_basedir_local
    update_repo_local
    copy_custom_extra_local
    artisan_optimize_local
    pack_deps_local
    init_basedir_remote
    fetch_repo_remote
    scp_deps_to_remote
    extract_deps_on_remote
    sync_shared
    update_permissions
    envfile_link
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    cleanup_tempfiles_local
    cleanup_tempfiles_remote
    artisan_reset_local
    notice_done
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('deploy_mix_update', ['on' => 'local']); ?>
    <?php /*deploy_mix_update*/ ?>
    show_env
    init_basedir_local
    update_repo_local
    deps_update_local
    copy_custom_extra_local
    artisan_optimize_local
    pack_deps_local
    init_basedir_remote
    fetch_repo_remote
    scp_deps_to_remote
    extract_deps_on_remote
    sync_shared
    update_permissions
    envfile_link
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    cleanup_tempfiles_local
    cleanup_tempfiles_remote
    artisan_reset_local
    notice_done
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('deploy_localrepo_install', ['on' => 'local']); ?>
    <?php /*deploy_localrepo_install*/ ?>
    show_env
    init_basedir_local
    fetch_repo_localrepo
    copy_env_localrepo
    chdir_localrepo
    deps_install_localrepo
    copy_custom_extra_localrepo
    artisan_optimize_localrepo
    pack_release_localrepo
    init_basedir_remote
    scp_release_to_remote
    extract_release_on_remote
    sync_shared
    update_permissions
    envfile_link
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    cleanup_tempfiles_local
    cleanup_tempfiles_remote
    notice_done
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('deploy_localrepo_pack', ['on' => 'local']); ?>
    <?php /*deploy_localrepo_pack*/ ?>
    show_env
    init_basedir_local
    fetch_repo_localrepo
    copy_env_localrepo
    pack_deps_local
    chdir_localrepo
    deps_extract_localrepo
    copy_custom_extra_localrepo
    artisan_optimize_localrepo
    pack_release_localrepo
    init_basedir_remote
    scp_release_to_remote
    extract_release_on_remote
    sync_shared
    update_permissions
    envfile_link
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    cleanup_tempfiles_local
    cleanup_tempfiles_remote
    notice_done
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('deploy_remote_install', ['on' => 'web']); ?>
    <?php /*deploy_remote_install*/ ?>
    show_env
    init_basedir_remote
    fetch_repo_remote
    sync_shared
    update_permissions
    envfile_link
    chdir_release
    deps_install_remote
    copy_custom_extra_remote
    artisan_optimize_remote
    database_migrate
    link_newrelease
    cleanup_oldreleases
    notice_done
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('deploy_init', ['on' => 'local']); ?>
    init_basedir_local
    init_basedir_remote
    scp_env_to_remote
    link_env_on_remote
<?php $__container->endMacro(); ?>
<?php $__container->startMacro('rollback'); ?>
    <?php /*database_migrate_public_rollback*/ ?>
    link_rollback
<?php $__container->endMacro(); ?>
<?php $__container->startTask('showcmdlist',['on' => 'local']); ?>
    echo '----';
    echo 'deploy';
    echo 'manscprelease';
    echo 'mandeployrelease';
    echo 'deploy_mix_pack';
    echo 'deploy_localrepo_install';
    echo 'deploy_remote_install';
    echo 'deploy_init';
    echo 'rollback';
    echo 'show_env';
    echo '----';
<?php $__container->endTask(); ?>
<?php $__container->startTask('show_env',['on' => 'web']); ?>
    echo '...';
    echo 'Current Release Name: <?php echo $release; ?>';
    echo 'Current environment is <?php echo $env; ?>';
    echo 'Current branch is <?php echo $branch; ?>';
    echo 'Deployment Start at <?php echo $dateDisplay; ?>';
    echo '----';
<?php $__container->endTask(); ?>
<?php $__container->startTask('init_basedir_remote',['on' => 'web']); ?>
    [ -d <?php echo $release_dir; ?> ] || mkdir -p <?php echo $release_dir; ?>;
    [ -d <?php echo $shared_dir; ?> ] || mkdir -p <?php echo $shared_dir; ?>;
    [ -d <?php echo $shared_dir; ?>/storage ] || mkdir -p <?php echo $shared_dir; ?>/storage;
    [ -d <?php echo $app_base; ?>/tmp ] || mkdir -p <?php echo $app_base; ?>/tmp;
<?php $__container->endTask(); ?>
<?php $__container->startTask('init_basedir_local',['on' => 'local']); ?>
    [ -d <?php echo $local_envoydeploy_base; ?> ] || mkdir -p <?php echo $local_envoydeploy_base; ?>;
    [ -d <?php echo $local_envoydeploy_base; ?>/deps ] || mkdir -p <?php echo $local_envoydeploy_base; ?>/deps;
    [ -d <?php echo $local_envoydeploy_base; ?>/releases ] || mkdir -p <?php echo $local_envoydeploy_base; ?>/releases;
<?php $__container->endTask(); ?>
<?php $__container->startTask('scp_env_to_remote',['on' => 'local']); ?>
    echo "scp env to remote...";
    [ -f <?php echo $local_dir; ?>/.env.<?php echo $env; ?> ] && scp <?php echo $local_dir; ?>/.env.<?php echo $env; ?> <?php echo $ssh; ?>:<?php echo $app_base; ?>/.env.<?php echo $env; ?>;
    [ -f <?php echo $local_dir; ?>/envoy.config.<?php echo $env; ?>.php ] && scp <?php echo $local_dir; ?>/envoy.config.<?php echo $env; ?>.php <?php echo $ssh; ?>:<?php echo $app_base; ?>/envoy.config.<?php echo $env; ?>.php;
    echo "scp env to remote Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('link_env_on_remote',['on' => 'web']); ?>
    echo "link env on remote...";
    [ -f <?php echo $app_base; ?>/.env.<?php echo $env; ?> ] && rm -rf <?php echo $app_base; ?>/.env;
    [ -f <?php echo $app_base; ?>/.env.<?php echo $env; ?> ] && ln -nfs <?php echo $app_base; ?>/.env.<?php echo $env; ?> <?php echo $app_base; ?>/.env;
    [ -f <?php echo $app_base; ?>/.env.<?php echo $env; ?> ] && chgrp -h <?php echo $serviceowner; ?> <?php echo $app_base; ?>/.env;

    [ -f <?php echo $app_base; ?>/envoy.config.<?php echo $env; ?>.php ] && rm -rf <?php echo $app_base; ?>/envoy.config.php;
    [ -f <?php echo $app_base; ?>/envoy.config.<?php echo $env; ?>.php ] && ln -nfs <?php echo $app_base; ?>/envoy.config.<?php echo $env; ?>.php <?php echo $app_base; ?>/envoy.config.php;
    [ -f <?php echo $app_base; ?>/envoy.config.<?php echo $env; ?>.php ] && chgrp -h <?php echo $serviceowner; ?> <?php echo $app_base; ?>/envoy.config.php;
    echo "link env on remote Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('fetch_repo_remote',['on' => 'web']); ?>
    echo "Repository cloning...";
    cd <?php echo $release_dir; ?>;
    git clone <?php echo $repo; ?> --branch=<?php echo $branch; ?> --depth=1 <?php echo $release; ?>;
    echo "Repository cloned.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('update_repo_local',['on' => 'local']); ?>
    echo "Repository update...";
    cd <?php echo $local_dir; ?>;
    git fetch origin;
    git pull;
    echo "Repository updated.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('fetch_repo_local',['on' => 'local']); ?>
    echo "Repository pull...";
    cd <?php echo $local_dir; ?>;
    git fetch origin;
    git checkout -B <?php echo $branch; ?> origin/<?php echo $branch; ?>;
    git pull;
    echo "Repository pulled.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('fetch_repo_localrepo',['on' => 'local']); ?>
    echo "Repository cloning...";
    echo <?php echo $local_envoydeploy_base; ?>;
    echo <?php echo $appname; ?>;
    cd <?php echo $local_envoydeploy_base; ?>;
    [ -d <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?> ] && echo "exists previous repo clone,need to remove.";
    [ -d <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?> ] && rm -rf <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    git clone <?php echo $repo; ?> --branch=<?php echo $branch; ?> --depth=1 <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    echo "Repository cloned.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('copy_env_localrepo',['on' => 'local']); ?>
    echo "Repo Environment file setup";
    [ -f <?php echo $local_dir; ?>/.env.development ] && cp -af <?php echo $local_dir; ?>/.env.development <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env;
    [ -f <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env.development ] && cp -af <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env.development <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env;
    [ -f <?php echo $local_dir; ?>/.env ] && cp -af <?php echo $local_dir; ?>/.env <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env;
    [ -f <?php echo $local_dir; ?>/.env.<?php echo $env; ?> ] && cp -af <?php echo $local_dir; ?>/.env.<?php echo $env; ?> <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env;
    [ -f <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env.<?php echo $env; ?> ] && cp -af <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env.<?php echo $env; ?> <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/.env;
    echo "Repo Environment file setup done";
<?php $__container->endTask(); ?>
<?php $__container->startTask('sync_shared',['on' => 'web']); ?>
    <?php /*#cp -af <?php echo $release_dir; ?>/<?php echo $release; ?>/storage/* <?php echo $shared_dir; ?>/storage/;*/ ?>
    rsync --progress -e ssh -avzh --delay-updates --exclude "*.logs" <?php echo $release_dir; ?>/<?php echo $release; ?>/storage/ <?php echo $shared_dir; ?>/storage/;
    rm -rf <?php echo $release_dir; ?>/<?php echo $release; ?>/storage;
    ln -nfs <?php echo $shared_dir; ?>/storage <?php echo $release_dir; ?>/<?php echo $release; ?>/storage;
    echo "New Release Shared directory setup";
<?php $__container->endTask(); ?>
<?php $__container->startTask('update_permissions',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>;
    chgrp -R <?php echo $serviceowner; ?> <?php echo $release; ?> <?php echo $shared_dir; ?>/storage;
    chmod -R ug+rwx <?php echo $release; ?> <?php echo $shared_dir; ?>/storage;
<?php $__container->endTask(); ?>
<?php $__container->startTask('envfile_link',['on' => 'web']); ?>
    [ -f <?php echo $release_dir; ?>/<?php echo $release; ?>/.env ] && rm -rf <?php echo $release_dir; ?>/<?php echo $release; ?>/.env;
    ln -nfs <?php echo $app_base; ?>/.env <?php echo $release_dir; ?>/<?php echo $release; ?>/.env;
    chgrp -h <?php echo $serviceowner; ?> <?php echo $release_dir; ?>/<?php echo $release; ?>/.env;

    [ -f <?php echo $release_dir; ?>/<?php echo $release; ?>/envoy.config.php ] && rm -rf <?php echo $release_dir; ?>/<?php echo $release; ?>/envoy.config.php;
    ln -nfs <?php echo $app_base; ?>/envoy.config.php <?php echo $release_dir; ?>/<?php echo $release; ?>/envoy.config.php;
    chgrp -h <?php echo $serviceowner; ?> <?php echo $release_dir; ?>/<?php echo $release; ?>/envoy.config.php;
    echo "Environment file symbolic link setup";
<?php $__container->endTask(); ?>
<?php $__container->startTask('chdir_localrepo',['on' => 'local']); ?>
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    echo "Change directory to <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>";
<?php $__container->endTask(); ?>
<?php $__container->startTask('chdir_release',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    echo "Change directory to <?php echo $release_dir; ?>/<?php echo $release; ?>";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_install_remote',['on' => 'web']); ?>
    echo "Dependencies install...";
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    composer install --prefer-dist --no-scripts --no-interaction;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    npm install;
    bower install;
    echo "Dependencies installed.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_install_local',['on' => 'local']); ?>
    echo "Dependencies install...";
    cd <?php echo $local_dir; ?>;
    composer install --prefer-dist --no-scripts --no-interaction;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    npm install;
    bower install;
    echo "Dependencies installed.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_install_localrepo',['on' => 'local']); ?>
    echo "Dependencies install...";
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    composer install --prefer-dist --no-scripts --no-interaction;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    <?php /*npm install;*/ ?>
    <?php /*bower install;*/ ?>
    echo "Dependencies installed.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_extract_localrepo',['on' => 'local']); ?>
    echo "Dependencies extract...";
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    <?php /*composer install --prefer-dist --no-scripts --no-interaction;*/ ?>
    tar zxf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    <?php /*npm install;*/ ?>
    <?php /*bower install;*/ ?>
    echo "Dependencies extracted.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_update_remote',['on' => 'web']); ?>
    echo "Dependencies update...";
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    composer update -vv --no-scripts --no-interaction;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    npm update;
    bower update;
    echo "Dependencies updated.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_update_local',['on' => 'local']); ?>
    echo "Dependencies update...";
    cd <?php echo $local_dir; ?>;
    composer update -vv --no-scripts --no-interaction;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    npm update;
    bower update;
    echo "Dependencies updated.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('deps_update_localrepo',['on' => 'local']); ?>
    echo "Dependencies update...";
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    composer update -vv --no-scripts --no-interaction;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    npm update;
    bower update;
    echo "Dependencies updated.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('copy_custom_extra_remote',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    if [ -d <?php echo $release_dir; ?>/<?php echo $release; ?>/extra/custom ]; then
        cp -af <?php echo $release_dir; ?>/<?php echo $release; ?>/extra/custom/* <?php echo $release_dir; ?>/<?php echo $release; ?>/;
    fi
<?php $__container->endTask(); ?>
<?php $__container->startTask('copy_custom_extra_local',['on' => 'local']); ?>
    cd <?php echo $local_dir; ?>;
    if [ -d <?php echo $local_dir; ?>/extra/custom ]; then
        cp -af <?php echo $local_dir; ?>/extra/custom/* <?php echo $local_dir; ?>/;
    fi
<?php $__container->endTask(); ?>
<?php $__container->startTask('copy_custom_extra_localrepo',['on' => 'local']); ?>
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    if [ -d <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/extra/custom ]; then
        cp -af <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/extra/custom/* <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/;
    fi
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_optimize_remote',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    php artisan config:cache;
    php artisan route:cache;
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_optimize_local',['on' => 'local']); ?>
    cd <?php echo $local_dir; ?>;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    php artisan config:cache;
    php artisan route:cache;
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_optimize_localrepo',['on' => 'local']); ?>
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    php artisan config:cache;
    php artisan route:cache;
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_reset_local',['on' => 'local']); ?>
    cd <?php echo $local_dir; ?>;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    php artisan config:clear;
    php artisan route:clear;
    <?php /*php artisan cache:clear*/ ?>
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_reset_localrepo',['on' => 'local']); ?>
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    composer dump-autoload --optimize;
    php artisan clear-compiled --env=<?php echo $env; ?>;
    php artisan optimize --env=<?php echo $env; ?>;
    php artisan config:clear;
    php artisan route:clear;
    php artisan cache:clear;
<?php $__container->endTask(); ?>
<?php $__container->startTask('pack_deps_local',['on' => 'local']); ?>
    echo "pack deps...";
    [ -f <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz ] && rm -rf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz;
    cd <?php echo $local_dir; ?>;
    [ -d <?php echo $local_dir; ?>/node_modules ] && tar czf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz vendor node_modules;
    [ ! -d <?php echo $local_dir; ?>/node_modules ] && tar czf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz vendor;
    echo "pack deps Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('pack_deps_localrepo',['on' => 'local']); ?>
    echo "pack deps...";
    [ -f <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz ] && rm -rf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz;
    cd <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>;
    [ -d <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/node_modules ] && tar czf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz vendor node_modules;
    [ ! -d <?php echo $local_envoydeploy_base; ?>/releases/<?php echo $appname; ?>/node_modules ] && tar czf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz vendor;
    echo "pack deps Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('pack_release_localrepo',['on' => 'local']); ?>
    echo "pack release...";
    [ -f <?php echo $local_envoydeploy_base; ?>/releases/release.tgz ] && rm -rf <?php echo $local_envoydeploy_base; ?>/releases/release.tgz;
    cd <?php echo $local_envoydeploy_base; ?>/releases/;
    tar czf <?php echo $local_envoydeploy_base; ?>/releases/release.tgz <?php echo $appname; ?>;
    echo "pack release Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('scp_deps_to_remote',['on' => 'local']); ?>
    echo "scp deps to remote...";
    [ -f <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz ] && scp <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz <?php echo $ssh; ?>:<?php echo $app_base; ?>/tmp/deps.tgz;
    echo "scp deps to remote Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('scp_release_to_remote',['on' => 'local']); ?>
    echo "scp release to remote...";
    [ -f <?php echo $local_envoydeploy_base; ?>/releases/release.tgz ] && scp <?php echo $local_envoydeploy_base; ?>/releases/release.tgz <?php echo $ssh; ?>:<?php echo $app_base; ?>/tmp/release.tgz;
    echo "scp release to remote Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('extract_deps_on_remote',['on' => 'web']); ?>
    echo "extract deps on remote...";
    [ -f <?php echo $app_base; ?>/tmp/deps.tgz ] && tar zxf <?php echo $app_base; ?>/tmp/deps.tgz -C <?php echo $release_dir; ?>/<?php echo $release; ?>;
    echo "extract deps on remote Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('extract_release_on_remote',['on' => 'web']); ?>
    echo "extract release on remote...";
    [ -d <?php echo $app_base; ?>/tmp/<?php echo $appname; ?> ] && rm -rf <?php echo $app_base; ?>/tmp/<?php echo $appname; ?>;
    [ -f <?php echo $app_base; ?>/tmp/release.tgz ] && tar zxf <?php echo $app_base; ?>/tmp/release.tgz -C <?php echo $app_base; ?>/tmp;
    [ -d <?php echo $release_dir; ?>/<?php echo $release; ?> ] && rm -rf <?php echo $release_dir; ?>/<?php echo $release; ?>;
    mv <?php echo $app_base; ?>/tmp/<?php echo $appname; ?> <?php echo $release_dir; ?>/<?php echo $release; ?>;
    echo "extract release on remote Done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_keygen',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan key:generate;
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_down',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan down;
<?php $__container->endTask(); ?>
<?php $__container->startTask('artisan_up',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan up;
<?php $__container->endTask(); ?>
<?php $__container->startTask('database_migrate',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan migrate --env=<?php echo $env; ?> --force --no-interaction;
<?php $__container->endTask(); ?>
<?php $__container->startTask('database_migrate_rollback',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan migrate:rollback --env=<?php echo $env; ?> --force --no-interaction;
<?php $__container->endTask(); ?>
<?php $__container->startTask('database_migrate_public_rollback',['on' => 'web']); ?>
    cd <?php echo $app_dir; ?>;
    php artisan migrate:rollback --env=<?php echo $env; ?> --force --no-interaction;
<?php $__container->endTask(); ?>
<?php $__container->startTask('database_migrate_seed',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan migrate --seed --env=<?php echo $env; ?> --force --no-interaction;
<?php $__container->endTask(); ?>
<?php $__container->startTask('database_migrate_refresh',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan migrate:refresh --env=<?php echo $env; ?> --force --no-interaction;
<?php $__container->endTask(); ?>
<?php $__container->startTask('database_migrate_refresh_seed',['on' => 'web']); ?>
    cd <?php echo $release_dir; ?>/<?php echo $release; ?>;
    php artisan migrate:refresh --seed --env=<?php echo $env; ?> --force --no-interaction;
<?php $__container->endTask(); ?>
<?php $__container->startTask('link_newrelease',['on' => 'web']); ?>
    echo "Deploy new Release link";
    cd <?php echo $app_base; ?>;
    [ -d <?php echo $prev_dir; ?> ] && unlink <?php echo $prev_dir; ?>;
    [ -d <?php echo $app_dir; ?> ] && mv <?php echo $app_dir; ?> <?php echo $prev_dir; ?>;
    ln -nfs <?php echo $release_dir; ?>/<?php echo $release; ?> <?php echo $app_dir; ?>;
    chgrp -h <?php echo $serviceowner; ?> <?php echo $app_dir; ?>;
    echo "Deployment (<?php echo $release; ?>) symbolic link created";
<?php $__container->endTask(); ?>
<?php $__container->startTask('link_prevrelease',['on' => 'web']); ?>
    cd <?php echo $app_base; ?>;
    if [ ! -d <?php echo $prev_dir; ?> ]; then
        echo "noprevious link to rollback";
    else
        [ ! -d <?php echo $app_dir; ?> ] || mv <?php echo $app_dir; ?> <?php echo $last_dir; ?>;
        [ ! -d <?php echo $prev_dir; ?> ] || mv <?php echo $prev_dir; ?> <?php echo $app_dir; ?>;
    fi
    echo "Rollback to previous symbolic link";
<?php $__container->endTask(); ?>
<?php $__container->startTask('link_lastrelease',['on' => 'web']); ?>
    cd <?php echo $app_base; ?>;
    if [ ! -d <?php echo $last_dir; ?> ]; then
        echo "nolast link to symbolic link";
    else
        [ ! -d <?php echo $app_dir; ?> ] || mv <?php echo $app_dir; ?> <?php echo $prev_dir; ?>;
        [ ! -d <?php echo $last_dir; ?> ] || mv <?php echo $last_dir; ?> <?php echo $app_dir; ?>;
    fi
    echo "Reset to last symbolic link";
<?php $__container->endTask(); ?>
<?php $__container->startTask('link_rollback',['on' => 'web']); ?>
    cd <?php echo $app_base; ?>;
    if [ -d <?php echo $last_dir; ?> ]; then
        [ ! -d <?php echo $app_dir; ?> ] || mv <?php echo $app_dir; ?> <?php echo $prev_dir; ?>;
        [ ! -d <?php echo $last_dir; ?> ] || mv <?php echo $last_dir; ?> <?php echo $app_dir; ?>;
        echo "Reset to last symbolic link";
    elif [ -d <?php echo $prev_dir; ?> ] && [ ! -d <?php echo $last_dir; ?> ]; then
        [ ! -d <?php echo $app_dir; ?> ] || mv <?php echo $app_dir; ?> <?php echo $last_dir; ?>;
        [ ! -d <?php echo $prev_dir; ?> ] || mv <?php echo $prev_dir; ?> <?php echo $app_dir; ?>;
        echo "Rollback to previous symbolic link";
    else
        echo "noprevious link to rollback";
    fi
<?php $__container->endTask(); ?>

<?php $__container->startTask('cleanup_oldreleases',['on' => 'web']); ?>
    echo 'Cleanup up old releases';
    cd <?php echo $release_dir; ?>;
    <?php /*ls -1d release_* | head -n -3 | xargs -d '\n' rm -Rf;*/ ?>
    (ls -rd <?php echo $release_dir; ?>/*|head -n 4;ls -d <?php echo $release_dir; ?>/*)|sort|uniq -u|xargs rm -rf;
    echo "Cleanup up done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('cleanup_tempfiles_local',['on' => 'local']); ?>
    echo 'Cleanup up tempfiles';
    cd <?php echo $local_envoydeploy_base; ?>;
    [ -f <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz ] && rm -rf <?php echo $local_envoydeploy_base; ?>/deps/deps.tgz;
    [ -f <?php echo $local_envoydeploy_base; ?>/releases/release.tgz ] && rm -rf <?php echo $local_envoydeploy_base; ?>/releases/release.tgz;
    echo "Cleanup up done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('cleanup_tempfiles_remote',['on' => 'web']); ?>
    echo 'Cleanup up tempfiles';
    cd <?php echo $app_base; ?>/tmp;
    [ -d <?php echo $app_base; ?>/tmp/<?php echo $appname; ?> ] && rm -rf <?php echo $app_base; ?>/tmp/<?php echo $appname; ?>;
    [ -f <?php echo $app_base; ?>/tmp/deps.tgz ] && rm -rf <?php echo $app_base; ?>/tmp/deps.tgz;
    [ -f <?php echo $app_base; ?>/tmp/release.tgz ] && rm -rf <?php echo $app_base; ?>/tmp/release.tgz;
    echo "Cleanup up done.";
<?php $__container->endTask(); ?>
<?php $__container->startTask('notice_done',['on' => 'web']); ?>
    echo "Deployment (<?php echo $release; ?>) done.";
<?php $__container->endTask(); ?>

