# AntiServerStop

Require a password to stop an Axolotl-PM server with a command

[![CI](https://github.com/NhanAZ-Plugins/AntiServerStop/actions/workflows/build.yml/badge.svg)](https://github.com/NhanAZ-Plugins/AntiServerStop/actions/workflows/build.yml)
[![Latest release](https://img.shields.io/github/v/release/NhanAZ-Plugins/AntiServerStop)](https://github.com/NhanAZ-Plugins/AntiServerStop/releases/latest)
[![License](https://img.shields.io/github/license/NhanAZ-Plugins/AntiServerStop)](https://github.com/NhanAZ-Plugins/AntiServerStop/blob/master/LICENSE)
[![Discord](https://img.shields.io/discord/986553214889517088?label=Discord&logo=discord&logoColor=white&color=5865F2)](https://discord.gg/j2X83ujT6c)


## Behavior

The plugin generates a 16-character password on first enable and saves it in `plugins/AntiServerStop/config.yml` under the server's plugin directory. The generated password persists across restarts. The `/stop <password>` command requires the `antiserverstop.command` permission, which defaults to operators. A wrong password leaves the server running. A missing or invalid password in the config also prevents this command from stopping the server.

```yaml
password: replace_with_your_private_password
wrongPassword: Wrong password!
```

Restart the server after editing the config. Restrict access to the config file and to consoles or remote administration systems that may record typed commands. This plugin protects its `/stop` command. It cannot prevent someone with operating system access from terminating the server process.

## Requirements and compatibility

- Axolotl-PM with plugin API `5.0.0`.
- PHP 8.1 or newer in the Axolotl-PM 5 toolchain.

The [build workflow](.github/workflows/build.yml) pins the Axolotl-PM source used for PHPStan level max. The tested runtime version is recorded in release evidence. Compatibility with every Axolotl-PM 5.x release has not been established.

## Installation

Download `AntiServerStop.phar` from a verified [GitHub release](https://github.com/NhanAZ-Plugins/AntiServerStop/releases), place it in the server's `plugins/` directory and restart the server. Read the generated password from `plugins/AntiServerStop/config.yml` before using `/stop`.

## Building and testing

The [build workflow](.github/workflows/build.yml) runs PHPStan level max, builds the plugin PHAR with [DevTools](https://github.com/NhanAZ/DevTools), and verifies the PHAR contents and checksum. The workflow pins the builder revision. An isolated server check verifies that a wrong password is rejected and the correct password stops the server. A Bedrock client command test remains a separate check.

## License and support

The plugin source is licensed under [MIT](LICENSE). For help, use [NhanAZ Discord](https://discord.gg/j2X83ujT6c).
