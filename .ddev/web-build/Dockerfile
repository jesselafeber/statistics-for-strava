# Temporarily allow unauthenticated packages from sury.org (their GPG key expired)
RUN echo 'APT::Get::AllowUnauthenticated "true";' > /etc/apt/apt.conf.d/99allow-unauth && \
    echo 'Acquire::AllowInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99allow-unauth && \
    apt-get -o Acquire::AllowInsecureRepositories=true update && \
    apt-get -o APT::Get::AllowUnauthenticated=true install -y geos-bin php${DDEV_PHP_VERSION}-zstd && \
    rm /etc/apt/apt.conf.d/99allow-unauth && \
    rm -rf /var/lib/apt/lists/*

# Install the Go toolchain to build the fit-tool .FIT decoder (see docker/fit-tool).
# Debian trixie only ships Go 1.24, but docker/fit-tool/go.mod requires 1.25, so we
# pull the official tarball. The binary itself is built at container start by the
# post-start hook in .ddev/config.yaml, since the source is only mounted at runtime.
ARG GO_VERSION=1.25.0
RUN ARCH="$(dpkg --print-architecture)" && \
    curl -fsSL "https://go.dev/dl/go${GO_VERSION}.linux-${ARCH}.tar.gz" -o /tmp/go.tar.gz && \
    rm -rf /usr/local/go && tar -C /usr/local -xzf /tmp/go.tar.gz && rm /tmp/go.tar.gz && \
    ln -sf /usr/local/go/bin/go /usr/local/bin/go
