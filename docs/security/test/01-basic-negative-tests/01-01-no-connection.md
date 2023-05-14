# Scenario 1-01: No Connection

Users who are not connected to nodes in any way, can not have access to them:

<div id="graph" class="graph-container" style="height:300px"></div>

| Test         | Token  | Action                    | Options | Result | State of Test                                                 |
|:-------------|:-------|:--------------------------|:--------|:-------|:--------------------------------------------------------------|
| `1-01-01-01` | `User` | `🔵 GET /<Data>`          | -       | ❌ 404  | ✔️ implemented                                                |
| `1-01-01-02` | `User` | `🔵 GET /<Data>/parents`  | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-03` | `User` | `🔵 GET /<Data>/children` | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-04` | `User` | `🔵 GET /<Data>/related`  | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-05` | `User` | `🔵 GET /<Data>`          | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-06` | `User` | `🟢 POST /<Data>`         | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-07` | `User` | `🟠 PUT /<Data>`          | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-08` | `User` | `🟠 PATCH /<Data>`        | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-09` | `User` | `🔴 DELETE /<Data>`       | -       | ❌ 404  | 🚧 todo                                                       |
| `1-01-01-20` | `User` | `🔵 GET /<Data>/file`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-21` | `User` | `🟢 POST /<Data>/file`    | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-22` | `User` | `🟠 PUT /<Data>/file`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-23` | `User` | `🟠 PATCH /<Data>/file`   | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-24` | `User` | `🔴 DELETE /<Data>/file`  | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-25` | `User` | `🔴 GET /<Data>/file`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-30` | `User` | `🟣 COPY /<Data>`         | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-31` | `User` | `🟣 LOCK /<Data>`         | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-32` | `User` | `🟣 UNLOCK /<Data>`       | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-33` | `User` | `🟣 MKCOL /<Data>`        | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-34` | `User` | `🟣 MOVE /<Data>`         | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-35` | `User` | `🟣 PROPFIND /<Data>`     | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |
| `1-01-01-36` | `User` | `🟣 PORPPATCH /<Data>`    | -       | ❌ 404  | 🚧 todo [v0.2.0](https://github.com/ember-nexus/api/issues/7) |

<script>
renderGraph(document.getElementById('graph'), {
  nodes: [
    { id: 'user', ...userNode },
    { id: 'data', ...dataNode },
  ],
  edges: []
}, 'TB');
</script>
