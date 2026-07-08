# Temporarily allow unauthenticated packages from sury.org (their GPG key expired)
RUN echo 'APT::Get::AllowUnauthenticated "true";' > /etc/apt/apt.conf.d/99allow-unauth && \
    echo 'Acquire::AllowInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99allow-unauth && \
    apt-get -o Acquire::AllowInsecureRepositories=true update && \
    apt-get -o APT::Get::AllowUnauthenticated=true install -y geos-bin php${DDEV_PHP_VERSION}-zstd && \
    rm /etc/apt/apt.conf.d/99allow-unauth && \
    rm -rf /var/lib/apt/lists/*
