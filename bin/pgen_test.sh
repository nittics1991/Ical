cd $(dirname "$0")
cd ..
php dist/phpunit-skelgen.phar generate-test $*
