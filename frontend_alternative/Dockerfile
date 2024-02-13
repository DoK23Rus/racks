FROM node:12.16.1

WORKDIR /app

ENV PATH /app/node_modules/.bin:$PATH

COPY package.json package-lock.json /app/

RUN npm install && npm update -g

COPY . /app