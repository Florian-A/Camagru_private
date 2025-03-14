# minimal color codes
END=$'\x1b[0m
REV=$'\x1b[7m
GREY=$'\x1b[30m
RED=$'\x1b[31m
GREEN=$'\x1b[32m
CYAN=$'\x1b[36m
WHITE=$'\x1b[37m

NAME = inception

all : $(NAME)

$(NAME) : build
	@make up

build :
	@echo "${YELLOW}> Image building 🎉${END}"
	@docker-compose -f ./docker-compose.yml build
		
up :
	@echo "${YELLOW}> Turning up images 🎉${END}"
	@docker-compose -f ./docker-compose.yml up -d
	
down :
	@echo "${YELLOW}> Turning down images ❌${END}"
	@docker-compose -f ./docker-compose.yml down

re:
	@make down
	@make clean
	@make build
	@make up

clean: down
	@echo "${YELLOW}> Cleaning and deleting all images 🧹${END}"
	@ { docker volume ls -q ; echo null; } | xargs -r docker volume rm --force
	@rm -rf ${HOME}/data/

.PHONY:	all re down clean up build