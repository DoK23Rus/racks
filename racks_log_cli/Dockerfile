FROM golang:1.18

RUN apt-get update && apt-get install -y git

WORKDIR /usr/src/racks-log-cli

RUN mkdir -p /home/log
RUN groupadd log
RUN useradd -m -g log log -p racks
RUN usermod -aG log log

COPY go.mod .
COPY go.sum .

RUN go mod download

COPY . .

RUN go build -o racks-log-cli