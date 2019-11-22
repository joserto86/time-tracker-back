FROM redis:5.0.7-alpine

ADD docker/redis/redis.conf /etc/redis/redis.conf
ADD docker/redis/health-check.sh /etc/redis/health-check.sh
RUN chmod +x /etc/redis/health-check.sh

CMD ["redis-server", "/etc/redis/redis.conf"]

HEALTHCHECK --interval=1m --timeout=30s --retries=3 \
    CMD /etc/redis/health-check.sh
