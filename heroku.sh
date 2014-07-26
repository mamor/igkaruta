#!/bin/sh

if [ ${IS_HEROKU} ]
then
	echo "make app/config/.env file on Heroku."
	echo "LARAVEL_ENV=production" >> app/config/.env
	echo "LARAVEL_KEY=${LARAVEL_KEY}" >> app/config/.env
	echo "INSTAGRAM_CLIENT_ID=${INSTAGRAM_CLIENT_ID}" >> app/config/.env
	echo "INSTAGRAM_CLIENT_SECRET=${INSTAGRAM_CLIENT_SECRET}" >> app/config/.env
fi
