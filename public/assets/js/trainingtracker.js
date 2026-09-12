const playerButtons = document.querySelectorAll(".player-toggle");

function updatePlayerButton(button, absent) {
	button.classList.toggle("btn-danger", absent);
	button.classList.toggle("btn-outline-secondary", !absent);

	button.dataset.absent = absent ? "1" : "0";
}

function updateAbsentCount() {
	const absentCount = document.querySelectorAll(
		'.player-toggle[data-absent="1"]',
	).length;

	const absentBadge = document.querySelector("#absent-count");

	if (absentBadge) {
		absentBadge.textContent = `${absentCount} absent`;

		absentBadge.classList.toggle("d-none", absentCount === 0);
	}
}

async function refreshTrainingState(sessionDate) {
	try {
		const response = await fetch(
			`${window.trainingTracker.stateUrl}/${sessionDate}`,
			{
				headers: {
					Accept: "application/json",
				},
				cache: "no-store",
			},
		);

		if (!response.ok) {
			throw new Error(`Unable to load training state (${response.status})`);
		}

		const result = await response.json();

		const absentPlayerIds = result.absent_player_ids ?? [];

		playerButtons.forEach((button) => {
			const playerId = Number(button.dataset.playerId);

			updatePlayerButton(button, absentPlayerIds.includes(playerId));
		});

		updateAbsentCount();
	} catch (error) {
		console.error("Unable to refresh training state:", error);
	}
}

playerButtons.forEach((button) => {
	// Establish the current state from the HTML.
	button.dataset.absent = button.classList.contains("btn-danger") ? "1" : "0";

	button.addEventListener("click", async () => {
		const playerId = button.dataset.playerId;
		const sessionDate = button.dataset.sessionDate;

		const currentlyAbsent = button.dataset.absent === "1";
		const desiredAbsent = !currentlyAbsent;

		button.disabled = true;

		try {
			const response = await fetch(window.trainingTracker.setAbsenceUrl, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: new URLSearchParams({
					player_id: playerId,
					session_date: sessionDate,
					absent: desiredAbsent ? "1" : "0",
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

			updatePlayerButton(button, result.absent);
			updateAbsentCount();
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

	refreshTrainingState(trainingDate.value);

	setInterval(() => {
		refreshTrainingState(trainingDate.value);
	}, 2000);
}

const recentTrainingTable = document.querySelector("#recent-training-table");

if (recentTrainingTable) {
	$("#recent-training-table").tablesorter();
}
