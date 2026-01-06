# cache dependencies
FROM python:3.13 AS python_cache
ENV VIRTUAL_ENV=/venv
ENV PATH="$VIRTUAL_ENV/bin:$PATH"
WORKDIR /cache/
COPY requirements.txt .
RUN python -m venv /venv
RUN pip install -r requirements.txt

# build and start
FROM python:3.13-slim AS build
EXPOSE 80
WORKDIR /app
ENV VIRTUAL_ENV=/venv
ENV PATH="$VIRTUAL_ENV/bin:$PATH"

# Install dos2unix
RUN apt-get update && apt-get install -y dos2unix && rm -rf /var/lib/apt/lists/*

COPY --from=python_cache /venv /venv
COPY . .

# Fix line endings and make executable
RUN dos2unix ./entrypoint.sh && chmod +x ./entrypoint.sh

RUN strawberry export-schema main > schema.graphql
ENTRYPOINT [ "./entrypoint.sh" ]
