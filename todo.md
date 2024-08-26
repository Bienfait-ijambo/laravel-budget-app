
ssh-keygen -t ed25519 -C "ijamboizuba20@gmail.com"



docker swarm init --advertise-addr 143.244.157.28

docker stack deploy --compose-file docker-compose.yml budget_app

A Docker stack is a collection of services that define an application in a Docker Swarm cluster. Essentially, a stack is a way to deploy and manage multiple interrelated services as a single entity in a Docker Swarm environment.

deploy:
      mode: replicated
      replicas: 2
      restart_policy:
        condition: on-failure
      update_config:
        parallelism: 2


permissions to add 

chmod -R 777 sessions
chmod -R 777 logs
chmod -R 777 views
chmod -R 777 cache
chmod -R 777 storage



cache files nginx server:

location ~* \.(jpg|jpeg|png|gif|css|js|ico|webp|ttf|woff|woff2)$ {
        expires 30d;
        access_log off;
    }


docker run -d --name watchtower -e WATCHTOWER_TRACE=true -e WATCHTOWER_DEBUG=true -e WATCHTOWER_POLL_INTERVAL=10 -e WATCHTOWER_REMOVE_VOLUMES=true -v /var/run/docker.sock:/var/run/docker.sock containrrr/watchtower budget-app-container


docker swarm init --advertise-addr api

view info about node : docker node ls

docker stack deploy --compose-file docker-compose.yml budget_app


A Docker stack is a collection of services that define an application in a Docker Swarm cluster. Essentially, a stack is a way to deploy and manage multiple interrelated services as a single entity in a Docker Swarm environment.

overlay network


show running services:docker service


see running tasks: docker service ps 4iyf13pafhg5


stripe listen --forward-to http://143.244.157.28/stripe/webhook
