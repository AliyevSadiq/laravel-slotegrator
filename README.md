Installation
============

### Requirements
- Download **docker** and **docker-compose** binaries for initialization
- **make** executable

**Step 1:**
- Executing docker as regular user: **(only for linux)**

**Note:** If your docker executable already running by your user then, you can skip this step.

```shell
sudo groupadd docker
sudo usermod -aG docker ${USER}
su -s ${USER}

# For testing
docker --version
```

**Step 2:**

Open a command console, enter your project directory and execute:

```console
$ make init
$ make app-init
```

For running tests execute:

```console
$ make app-test
```
**Step 3:**

Create new .env file from .env.example

For running migration with seeder:

```console
$ make db-fresh
```

For generation api doc in swagger:

```console
$ make doc-generate
```
**Step 4:**

For uploading image to AWS add credentional to .env file
```console
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```
