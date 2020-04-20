# Dragon Framework

## Routes


getApp()->routing()->get('base');
getApp()->routing()->get('routes');
getApp()->routing()->get('router');

getApp()->routing()->get('active');
getApp()->routing()->get('name');
getApp()->routing()->get('guards');

getApp()->routing()->isActive(string $routeName): bool
getApp()->routing()->generateUrl(string $name, array $params=[], bool $absolute=false): string
