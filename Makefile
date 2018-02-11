DOCKER_USER ?=
DOCKER_PASS_FILE ?=
DOCKER_PASS ?=
TAG ?= $$(git log --format="%H" -n 1)
PHP_FPM_PORT ?= 9000
NGINX_PORT ?= 8080
VERSION ?= latest

login:
ifdef DOCKER_PASS_FILE
	cat $(DOCKER_PASS_FILE) | docker login -u ${DOCKER_USER} --password-stdin
else
	docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}
endif

build-core-api:
	docker build -t devpledge/core-api:${TAG} -f ./api.dockerfile . \
	&& docker tag devpledge/core-api:${TAG} devpledge/core-api:latest

push-core-api:
	docker push devpledge/core-api

run-core-api-dev:
	docker run -d \
	--name dp-core-api \
	--mount type=bind,source="$(PWD)",target=/var/www \
	-p $(PHP_FPM_PORT):9000 \
	devpledge/core-api:${VERSION}

run-core-api-prod:
	docker run -d \
	--name dp-core-api \
	--mount type=bind,source="$(PWD)/.env",target=/var/www/.env \
	-p $(PHP_FPM_PORT):9000 \
	devpledge/core-api:${VERSION}

build-web:
	docker build -t devpledge/core-api-web:${TAG} -f ./web.dockerfile . \
	&& docker tag devpledge/core-api-web:${TAG} devpledge/core-api-web:latest

push-web:
	docker push devpledge/core-api-web

run-web:
	docker run -d \
	--name dp-core-api-web \
	-p $(NGINX_PORT):80 \
	--link dp-core-api:api \
	devpledge/core-api-web:${VERSION}

