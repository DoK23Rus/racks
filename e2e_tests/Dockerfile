FROM python:3.10

WORKDIR /usr/src/app

ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1

RUN apt-get install curl wget tar -y
RUN apt-get upgrade -y
RUN pip install --upgrade pip

RUN mkdir -p /home/app && \
    groupadd test && \
    useradd -m -g test test -p test && \
    usermod -aG test test

ENV TEST_HOME=/home/app/test

RUN mkdir $TEST_HOME && \
    chown -R test:test $TEST_HOME

COPY ./requirements.txt $TEST_HOME

WORKDIR $TEST_HOME

RUN pip install -r requirements.txt

RUN mkdir test_results && \
    mkdir screenshots

COPY ./ $TEST_HOME
