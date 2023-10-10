<?php
// List of registered players with gender information
$players = array(
    "Player1" => "Boy",
    "Player2" => "Boy",
    "Player3" => "Girl",
    "Player4" => "Girl",
    "Player5" => "Boy",
    "Player6" => "Girl",
    "Player7" => "Boy",
    "Player8" => "Girl",
);

// List of referees
$referees = array("Referee_1", "Referee_2");

// Start date for matches
$startDate = strtotime("2023-10-13");

// Initialize an array to track referee match assignments per day
$refereeMatchesPerDay = array();

// Initialize an array to store matches
$matches = array();

// Loop through each date starting from the start date
$currentDate = $startDate;
$dayOfWeek = date('w', $currentDate);

while (count($players) >= 2 && $currentDate <= strtotime("2023-12-31")) {
    // Check if it's Sunday (dayOfWeek = 0), if not, assign matches
    if ($dayOfWeek != 0) {
        $availableReferees = $referees;

        foreach ($players as $player1 => $gender1) {
            foreach ($players as $player2 => $gender2) {
                if ($gender1 == $gender2) {
                    // Check if both players have the same gender
                    $referee = array_shift($availableReferees);
                    if ($referee) {
                        $match = array(
                            "Match" . count($matches) => array(
                                "Player1" => $player1,
                                "Player2" => $player2,
                                "Referee" => $referee,
                                "Date" => date('Y-m-d', $currentDate),
                            ),
                        );
                        array_push($matches, $match);

                        // Track referee match assignment
                        if (!isset($refereeMatchesPerDay[date('Y-m-d', $currentDate)])) {
                            $refereeMatchesPerDay[date('Y-m-d', $currentDate)] = array();
                        }
                        $refereeMatchesPerDay[date('Y-m-d', $currentDate)][] = $referee;

                        // Remove assigned players
                        unset($players[$player1]);
                        unset($players[$player2]);
                    }
                }
            }
        }
    }

    // Move to the next day
    $currentDate = strtotime("+1 day", $currentDate);
    $dayOfWeek = date('w', $currentDate);
}

// Display the matches
echo "Matches:\n";
foreach ($matches as $match) {
    foreach ($match as $matchName => $details) {
        echo "$matchName: {$details['Player1']} vs {$details['Player2']} (Referee: {$details['Referee']}, Date: {$details['Date']})\n";
    }
}
?>
