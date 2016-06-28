class nginx {
    package { 'nginx':
      ensure => 'latest',
      name   => 'nginx',
      require => Exec["apt-get update"],
    }

    service { 'nginx':
        ensure     => 'running',
        name       => 'nginx',
        enable     => 'true',
        hasstatus  => 'true',
        hasrestart => 'true',
        pattern    => 'nginx',
        require    => Package['nginx'],
    }

    file { '/etc/nginx/conf.d/selfblog.dev.conf':
        ensure  => present,          # файл должен существовать
        source => 'puppet:///modules/nginx/selfblog.dev.conf',
        mode    => '0644',             # права на файл - 0644
        owner   => 'root',           # владелец файла - root
        group   => 'root',            # группа файла - root
        before    => Service['nginx'],
    }
}