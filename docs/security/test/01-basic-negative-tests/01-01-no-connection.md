# Scenario 1-01: No Connection

Users who are not connected to nodes in any way, can not have access to them:

<div id="graph" class="graph-container" style="height:300px"></div>

| Test         | Token  | Action                    | Options | Result | State of Test                                                 |
|:-------------|:-------|:--------------------------|:--------|:-------|:--------------------------------------------------------------|
| `1-01-02-01` | `User` | `🔵 GET /<Data>`          | -       | ❌ 404  | ✔️ implemented                                                |
| `1-01-02-02` | `User` | `🔵 GET /<Data>/parents`  | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-03` | `User` | `🔵 GET /<Data>/children` | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-04` | `User` | `🔵 GET /<Data>/related`  | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-05` | `User` | `🔵 GET /<Data>`          | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-06` | `User` | `🟢 POST /<Data>`         | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-07` | `User` | `🟠 PUT /<Data>`          | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-08` | `User` | `🟠 PATCH /<Data>`        | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-09` | `User` | `🔴 DELETE /<Data>`       | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-02-20` | `User` | `🔵 GET /<Data>/file`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-21` | `User` | `🟢 POST /<Data>/file`    | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-22` | `User` | `🟠 PUT /<Data>/file`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-23` | `User` | `🟠 PATCH /<Data>/file`   | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-24` | `User` | `🔴 DELETE /<Data>/file`  | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-30` | `User` | `🟣 COPY /<Data>`         | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-31` | `User` | `🟣 LOCK /<Data>`         | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-32` | `User` | `🟣 UNLOCK /<Data>`       | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-33` | `User` | `🟣 MKCOL /<Data>`        | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-34` | `User` | `🟣 MOVE /<Data>`         | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-35` | `User` | `🟣 PROPFIND /<Data>`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-02-36` | `User` | `🟣 PROPPATCH /<Data>`    | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |

<script>
renderGraph(document.getElementById('graph'), {
  nodes: [
    { id: 'user', ...userNode },
    { id: 'data', ...dataNode },
  ],
  edges: []
}, 'TB');
</script>
