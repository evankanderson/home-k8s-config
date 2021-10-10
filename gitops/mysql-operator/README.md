# Presslabs MySQL helm chart, expanded via:

```
helm template mysql-operator --create-namespace --set orchestrator.secretName=mysql-operator-orc mysql-operator presslabs/mysql-operator
```

Note that if you don't set `orchestrator.secretName`, the helm chart will generate a (new) secret and then you'll check it in to your repo an leak it.
