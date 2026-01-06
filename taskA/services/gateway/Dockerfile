# cache dependencies
FROM node:22-slim AS node_cache
WORKDIR /cache
COPY package*.json ./
RUN npm config set registry http://registry.npmjs.org/ --global
RUN npm install --prefer-offline --no-audit --progress=true --loglevel verbose

# build and start
FROM node:22-slim AS build
WORKDIR /gateway
ENV APOLLO_ELV2_LICENSE=accept
ENV APOLLO_TELEMETRY_DISABLED=1

# Install dos2unix to fix line endings
RUN apt-get update && apt-get install -y dos2unix && rm -rf /var/lib/apt/lists/*

COPY --from=node_cache /cache .
COPY . .

# Fix line endings in entrypoint.sh
RUN dos2unix ./entrypoint.sh && chmod +x ./entrypoint.sh

RUN tar -xvf ./composer/supergraph-v2.9.3-bin.tar.gz -C ./node_modules/@apollo/rover/binary/

ENTRYPOINT [ "./entrypoint.sh" ]