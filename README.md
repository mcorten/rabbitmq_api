[![Build Status](https://travis-ci.org/mcorten/rabbitmq_api.svg?branch=master)](https://travis-ci.org/mcorten/rabbitmq_api)
[![Build Status](https://scrutinizer-ci.com/g/mcorten/rabbitmq_api/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mcorten/rabbitmq_api/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mcorten/rabbitmq_api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mcorten/rabbitmq_api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mcorten/rabbitmq_api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mcorten/rabbitmq_api/?branch=master)

# rabbitmq_api
Managing rabbitmq from your PHP code

# stability
for now the stability level is alpha which means:
- some commands have unit and integration test
- For some commands tests are not available so who knows what supprising bugs may appear ^^ (keeping things interesting)

so only use this is you want to contribute


# implemented features

| GET | PUT |  DELETE | POST| PATH |
| ------ | ------ | ------ | ------ | ------ |
| X |  |  |  | /api/overview |
| X | X |  |  | /api/cluster-name |
|  |  |  |  | /api/nodes |
|  |  |  |  | /api/extensions |
|  |  |  |  | /api/definitions |
|  |  |  |  | /api/definitions/vhost |
|  |  |  |  | /api/connections |
|  |  |  |  | /api/vhosts/vhost/connections |
|  |  |  |  | /api/connections/name |
|  |  |  |  | /api/connections/name/channels |
|  |  |  |  | /api/channels |
|  |  |  |  | /api/vhosts/vhost/channels |
|  |  |  |  | /api/channels/channel |
|  |  |  |  | /api/consumers |
|  |  |  |  | /api/consumers/vhost |
| X |  |  |  | /api/exchanges |
| X |  |  |  | /api/exchanges/vhost |
| X | X | X |  | /api/exchanges/vhost/name |
| X |  |  |  | /api/exchanges/vhost/name/bindings/source |
|  |  |  |  | /api/exchanges/vhost/name/bindings/destination |
|  |  |  | X | /api/exchanges/vhost/name/publish |
| X |  |  |  | /api/queues |
| X |  |  |  | /api/queues/vhost |
| X | X | X |  | /api/queues/vhost/name |
| X |  |  |  | /api/queues/vhost/name/bindings |
|  |  |  |  | /api/queues/vhost/name/contents |
|  |  |  |  | /api/queues/vhost/name/actions |
|  |  |  |  | /api/queues/vhost/name/get |
| X |  |  |  | /api/bindings |
| X |  |  |  | /api/bindings/vhost |
| X |  | X |  | /api/bindings/vhost/e/exchange/q/queue/props |
|  |  |  |  | /api/bindings/vhost/e/source/e/destination |
|  |  |  |  | /api/bindings/vhost/e/source/e/destination/props |
| X |  |  |  | /api/vhosts |
| X | X | X |  | /api/vhosts/name |
| X |  |  |  | /api/vhosts/name/permissionse |
| X |  |  |  | /api/users |
| X | X | X |  | /api/users/name |
| X |  |  |  | /api/users/user/permissions |
|  |  |  |  | /api/whoami |
|  |  |  |  | /api/permissions |
|  |  |  |  | /api/permissions/vhost/user |
|  |  |  |  | /api/parameters |
|  |  |  |  | /api/parameters/component |
|  |  |  |  | /api/parameters/component/vhost |
|  |  |  |  | /api/parameters/component/vhost/name |
|  |  |  |  | /api/global-parameters |
|  |  |  |  | /api/global-parameters/name |
|  |  |  |  | /api/policies |
|  |  |  |  | /api/policies/vhost |
|  |  |  |  | /api/policies/vhost/name |
|  |  |  |  | /api/aliveness-test/vhost |
|  |  |  |  | /api/healthchecks/node |
|  |  |  |  | /api/healthchecks/node/node |

