fixer:
	php-cs-fixer fix app/ --fixers=linefeed,trailing_spaces,unused_use,phpdoc_params,short_tag,return,visibility,php_closing_tag,braces,extra_empty_lines,function_declaration,include,controls_spaces,elseif,eof_ending

ide:
	php artisan clear-compiled
	php artisan ide-helper:generate
	php artisan optimize

apigen:
	rm -rf reports/apigen/
	apigen -s app/ -d reports/apigen/ \
	--source-code no \
	--todo yes \
	--exclude `pwd`/app/database,`pwd`/app/tests

phpcs:
	phpcs --standard=phpcs.xml \
	 --ignore=app/views/*.php,app/tests/*.php \
	app/

phpmd:
	phpmd app/ text phpmd.xml --exclude tests/

phpcpd:
	phpcpd app/

php:
	phpunit
	make phpcs
	make phpmd
	make phpcpd

coverage:
	rm -rf reports/phpunit/
	phpunit --coverage-html=reports/phpunit
