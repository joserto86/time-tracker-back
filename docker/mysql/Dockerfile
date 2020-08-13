FROM mysql:8.0.14

ARG UID=1000
ARG GID=1000

RUN mkdir /home/docker \
    && groupadd -r docker -g ${GID} \
    && useradd -u ${UID} -r -g docker -d /home/docker -s /bin/bash -c "Docker user" docker \
    && echo "docker:docker" | chpasswd \
    && chown -R docker:docker /home/docker

USER docker
