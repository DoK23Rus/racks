FROM python:3.10

WORKDIR /usr/src/app

ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install gcc python3-dev musl-dev -y && \
    pip install --upgrade pip

RUN mkdir -p /home/app && \
    groupadd app && \
    useradd -m -g app app -p racks && \
    usermod -aG app app

ENV APP_HOME=/home/app/web

RUN mkdir $APP_HOME && \
    mkdir $APP_HOME/staticfiles && \
    chown -R app:app $APP_HOME

COPY ./requirements.txt $APP_HOME

WORKDIR $APP_HOME

RUN pip install -r requirements.txt

COPY ./racks $APP_HOME

ENV BACKEND_ENTYPOINTS_DIR=$APP_HOME/entrypoints

RUN mkdir $BACKEND_ENTYPOINTS_DIR

COPY ./entrypoint_main.sh \
    ./entrypoint_unit.sh \
    ./entrypoint_linter.sh \
    ./entrypoint_typing.sh $BACKEND_ENTYPOINTS_DIR
