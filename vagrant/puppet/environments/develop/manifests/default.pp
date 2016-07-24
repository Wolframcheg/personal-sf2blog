exec {"apt-get update":
  path => "/usr/bin",
}

class { 'nginx': }

package { ["php5-common", "php-apc", "php5-mysql", "php5-fpm", "php5-cli"]:
  ensure => installed,
  notify => Service["nginx"],
#  require => [Exec["apt-get update"], Package['mysql-client'], Package['apache2']],
}

  service { 'php5-fpm':
    ensure     => 'running',
    enable     => 'true',
    hasrestart => 'true',
   # restart    => '/etc/init.d/php5-fpm restart',
  #  start      => '/etc/init.d/php5-fpm start',
    hasstatus  => true,
    require    => Package['php5-fpm'],
  }

file { '/etc/php5/fpm/pool.d/www.conf':
   ensure  => file,
   source => 'puppet:///modules/php/www.conf',
   mode    => '0644',             # права на файл - 0644
   owner   => 'root',           # владелец файла - root
   group   => 'root',            # группа файла - root
   require => Package['php5-fpm'],
   notify  => Service['php5-fpm'],
}

class { 'composer': }

class { 'mysql::server': }

mysql::db { 'selfblog':
  user     => 'selfblog',
  password => 'selfblog',
  host     => 'localhost',
}

class { 'nodejs':
  version => 'v0.10.25',
}