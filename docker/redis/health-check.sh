#!/usr/bin/env sh

set -e

redis-cli set 0 1
redis-cli get 0
