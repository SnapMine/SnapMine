FROM dunglas/frankenphp:builder AS builder
COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

# Forcer le toolchain Go 1.25 pour la build
ENV GOTOOLCHAIN=go1.25.0

#RUN git clone https://github.com/SnapMine/SnapSerialize.git

RUN go clean -modcache

ENV CGO_ENABLED=1 \
    CGO_CFLAGS="$(php-config --includes)" \
    CGO_LDFLAGS="$(php-config --ldflags) $(php-config --libs)" \
    XCADDY_GO_BUILD_FLAGS="-tags=nowatcher -ldflags='-w -s'"

RUN CGO_ENABLED=1 \
    XCADDY_SETCAP=1 \
    XCADDY_GO_BUILD_FLAGS="-ldflags='-w -s' -tags=nobadger,nomysql,nopgx" \
    CGO_CFLAGS=$(php-config --includes) \
    CGO_LDFLAGS="$(php-config --ldflags) $(php-config --libs)" \
    xcaddy build \
        --output /usr/local/bin/frankenphp \
        --with github.com/dunglas/frankenphp=./ \
        --with github.com/dunglas/frankenphp/caddy=./caddy/ \
        --with github.com/dunglas/caddy-cbrotli \
        # SnapMine extensions
        --with github.com/SnapMine/SnapSerialize/build



FROM dunglas/frankenphp
COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

RUN apt-get update
RUN apt-get install libgmp-dev libzip-dev -y
RUN docker-php-ext-install \
     sockets \
     gmp \
     zip


WORKDIR /app

COPY . .
ENTRYPOINT ["frankenphp"]
CMD ["php-cli", "server.php"]
