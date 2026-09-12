document.querySelectorAll(".player-toggle").forEach((button) => {
	button.addEventListener("click", async function () {
		const response = await fetch("/training/toggle-absence", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
			},
			body: new URLSearchParams({
				player_id: this.dataset.playerId,
				session_date: "<?= esc($sessionDate) ?>",
			}),
		});

		const result = await response.json();

		this.classList.toggle("btn-danger", result.absent);
		this.classList.toggle("btn-outline-secondary", !result.absent);
	});
});
