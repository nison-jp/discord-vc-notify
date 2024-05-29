# Discord VC Notify

This is a Discord Bot that notifies when someone joined voice channels.

# How to start
1. Access [Install Link](https://discord.com/oauth2/authorize?client_id=1245393629116235887) and choose server to install.
2. Make sure the "VC Join Notice" is on your target channel.

# How to run
* Necessary when you run your own Discord Application

## Create Application

1. Go to [Discord Developer Portal](https://discord.com/developers/applications) and create application.
2. Go to Installation Settings
3. In **Authorization Methods** section, check **"Guild Install"**.
4. In **Install Link** section, choose **"Discord Provided Link"**.
5. In "Default Install Settings" section, add **"bot"** scope.
6. Save and note your Install Link.
7. Go to Bot Settings
8. Click **[Reset Token]** button and note your token. 

## Execute bot
* Requirements: Docker environments and Internet Access

1. Clone this repository
2. Copy `.env.example` file to `.env`
3. In `.env` file, replace `<Your Discord Bot Token>` with your token
4. Execute `docker compose up -d`
