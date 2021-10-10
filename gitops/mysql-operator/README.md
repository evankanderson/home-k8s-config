# [Presslabs MySQL helm chart](https://github.com/bitpoke/mysql-operator), expanded via:

```
helm template mysql-operator --create-namespace --set orchestrator.secretName=mysql-operator-orc mysql-operator bitpoke/mysql-operator
```
And then `curl -LO https://github.com/bitpoke/mysql-operator/raw/master/deploy/charts/mysql-operator/crds/mysql.presslabs.org_mysqlbackups.yaml` for the CRDs, which _won't be provided if you have at least one installed on your cluster_!

**ONCE YOU'VE DONE THIS, YOU NEED TO MANUALLY ADD `namespace: mysql-operator` TO ALL THE NAMESPACED OBJECTS**

(TODO: use ytt/kustomize to do this)

Note that if you don't set `orchestrator.secretName`, the helm chart will generate a (new) secret and then you'll check it in to your repo and leak it.
