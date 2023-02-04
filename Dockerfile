FROM python:3.10

WORKDIR /usr/src/app

ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1

RUN apt-get update && apt-get upgrade -y && apt-get install gcc python3-dev musl-dev -y
RUN pip install --upgrade pip

RUN mkdir -p /home/app
RUN groupadd app
RUN useradd -m -g app app -p racks
RUN usermod -aG app app

ENV APP_HOME=/home/app/web

RUN mkdir $APP_HOME
RUN mkdir $APP_HOME/staticfiles
RUN chown -R app:app $APP_HOME

COPY ./requirements.txt $APP_HOME

WORKDIR $APP_HOME

RUN pip install -r requirements.txt

COPY ./racks $APP_HOME
COPY ./entrypoint_main.sh $APP_HOME
COPY ./entrypoint_unit.sh $APP_HOME
COPY ./entrypoint_linter.sh $APP_HOME
COPY ./entrypoint_typing.sh $APP_HOME
