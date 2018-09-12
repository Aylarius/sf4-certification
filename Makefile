.PHONY: stan security

stan:
	vendor/bin/phpstan analyse src
security:
	bin/console security:check
