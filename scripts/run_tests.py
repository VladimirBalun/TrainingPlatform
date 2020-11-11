import os

PHP_UNIT_FULL_PATH = "../application/vendor/bin/phpunit"
TESTS_DIRECTORY = "../application/tests"

os.system(PHP_UNIT_FULL_PATH + " " + TESTS_DIRECTORY)
