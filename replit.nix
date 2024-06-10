{ pkgs }: {
	deps = [
   pkgs.firefox
   pkgs.php80Packages.composer
		pkgs.php82
    pkgs.sqlite
	];
}