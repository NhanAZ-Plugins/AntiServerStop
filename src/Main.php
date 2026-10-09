<?php

declare(strict_types=1);

namespace NhanAZ\AntiServerStop;

use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\StopCommand;
use pocketmine\lang\KnownTranslationFactory;

class Main extends PluginBase {

	private Config $passwordConfig;

	private function generatorPassword(int $length = 16, string $characters = "*&^%$#@!0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): string {
		$password = "";
		$max = strlen($characters) - 1;
		for ($i = 0; $i < $length; ++$i) {
			$password .= $characters[random_int(0, $max)];
		}
		return $password;
	}

	protected function onLoad(): void {
		$commandMap = $this->getServer()->getCommandMap();
		$stopCommand = $commandMap->getCommand("stop");
		if ($stopCommand instanceof StopCommand) {
			$commandMap->unregister($stopCommand);
		}
	}

	protected function onEnable(): void {
		$this->passwordConfig = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
			"password" => $this->generatorPassword(),
			"wrongPassword" => "Wrong password!"
		]);
	}

	public function onCommand(CommandSender $sender, Command $command, string $commandLabel, array $args): bool {
		if ($command->getName() === "stop") {
			if (!isset($args[0])) {
				return false;
			}
			$password = $this->passwordConfig->get("password");
			if (!is_string($password) || $password === "") {
				$sender->sendMessage("Server stop password is not configured correctly.");
				return true;
			}
			if (!hash_equals($password, $args[0])) {
				$wrongPassword = $this->passwordConfig->get("wrongPassword", "Wrong password!");
				$sender->sendMessage(is_string($wrongPassword) ? $wrongPassword : "Wrong password!");
				return true;
			}
			Command::broadcastCommandMessage($sender, KnownTranslationFactory::commands_stop_start());
			$sender->getServer()->shutdown();
			return true;
		}
		return false;
	}
}
