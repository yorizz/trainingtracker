const playerButtons = document.querySelectorAll(".player-toggle");

playerButtons.forEach((button) => {
	button.addEventListener("click", async () => {
		const playerId = button.dataset.playerId;
		const sessionDate = button.dataset.sessionDate;

		button.disabled = true;

		try {
			const response = await fetch(window.trainingTracker.toggleAbsenceUrl, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: new URLSearchParams({
					player_id: playerId,
					session_date: sessionDate,
				}),
			});

			if (!response.ok) {
				const errorText = await response.text();

				console.error("Training Tracker server error:", {
					status: response.status,
					response: errorText,
				});

				throw new Error(`Unable to update absence (${response.status})`);
			}

			const result = await response.json();

			button.classList.toggle("btn-danger", result.absent);
			button.classList.toggle("btn-outline-secondary", !result.absent);

			const absentCount = document.querySelectorAll(
				".player-toggle.btn-danger",
			).length;

			const absentBadge = document.querySelector("#absent-count");

			if (absentBadge) {
				absentBadge.textContent = `${absentCount} absent`;

				absentBadge.classList.toggle("d-none", absentCount === 0);
			}
		} catch (error) {
			console.error(error);
		} finally {
			button.disabled = false;
		}
	});
});

const trainingDate = document.querySelector("#training-date");

if (trainingDate) {
	trainingDate.addEventListener("change", () => {
		if (!trainingDate.value) {
			return;
		}

		const trainingUrl = trainingDate.dataset.trainingUrl;

		window.location.href = `${trainingUrl}/${trainingDate.value}`;
	});
}

const recentTrainingTable = document.querySelector("#recent-training-table");

if (recentTrainingTable) {
	$("#recent-training-table").tablesorter();
}
