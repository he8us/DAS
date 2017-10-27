DAS ARG
=======

## Development
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhe8us%2FDAS.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhe8us%2FDAS?ref=badge_shield)

You should use Docker to run the application, you can find it [here](https://www.docker.com/products/overview)

If you run on OSX, you can use the tool I created called devbox:

### Setup
The init command will create all the containers needed to run 
```
./devbox init
``` 

### Teardown
```
./devbox down
```


### Tools

You should add each domain to your host file or setup dnsmasq

| Tool       | Description                                    | Url                              |
| ---------- | ---------------------------------------------- | -------------------------------- |
| DAS        | The application, based on Symfony 3.1          | http://www.das.dev/app_dev.php   |
| PHPMyAdmin | MySQL Administration                           | http://sql.das.dev               |
| Maildev    | See the mails that are sent by the application | http://mail.das.dev              |
| Nodebuild  | Assets Bundler based on webpack                | http://build.das.dev             |


## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fhe8us%2FDAS.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fhe8us%2FDAS?ref=badge_large)