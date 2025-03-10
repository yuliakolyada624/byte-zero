<div class="offcanvas order-details offcanvas-end" tabindex="-1" id="order-full-details-<?= $order['id'] ?>"
    aria-labelledby="offcanvasRightLabel">
<?php
    //d($order);
?>
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="offcanvasRightLabel">
            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#1" aria-controls="offcanvasRight">
                <svg class="icon icon-arrow ">
                    <use href="/assets/themes/default/icon/icons/icons.svg#arrow" />
                </svg>
            </button>
            Back
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h1 class="mb-3">Order Details</h1>
        <div class="card p-4 rounded-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <p>Report Type: <b>Medical Chronology</b></p>
                <p>Ordered By: <b class="text-main-blue"><?=get_user_full_name($order['creater_user_id']);?></b></p>
            </div>
            <div class="card p-3 bg-main-light border-0 mb-4 rounded-3">
                <div class="d-flex details">
                    <!-- First Table -->
                    <table>
                        <tbody>
                            <!-- Claim Number -->
                            <tr>
                                <td class="pb-2">Claim Number:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['claim_number'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Claim Type -->
                            <tr>
                                <td class="pb-2">Claim type:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php
                                    echo isset($order['claim_type'])
                                        ? htmlspecialchars(ucwords(str_replace('_', ' ', $order['claim_type'])))
                                        : '—';
                                    ?>
                                </th>
                            </tr>
                            <!-- Case Name -->
                            <tr>
                                <td class="pb-2">Case name:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['case_name'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Plaintiff First Name -->
                            <tr>
                                <td class="pb-2">Plaintiff First name:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['plaintiff_first_name'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Plaintiff Last Name -->
                            <tr>
                                <td class="pb-2">Plaintiff Last name:</td>
                                <th class="text-end fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['plaintiff_last_name'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Plaintiff DOB -->
                            <tr>
                                <td class="pb-2">Plaintiff DOB (Date of Birth):</td>
                                <th class="text-end fw-semibold" scope="row">
                                    <?php
                                    if (!empty($order['plaintiff_dob']) && $order['plaintiff_dob'] !== '0000-00-00') {
                                        echo date('m-d-Y', strtotime($order['plaintiff_dob']));
                                    } else {
                                        echo '—';
                                    }
                                    ?>
                                </th>
                            </tr>
                            <!-- Plaintiff Gender -->
                            <tr>
                                <td>Plaintiff gender:</td>
                                <th class="text-end fw-semibold" scope="row">
                                    <?php echo htmlspecialchars(ucfirst($order['plaintiff_gender'] ?? '—')); ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Separator -->
                    <span class="separator-table"></span>

                    <!-- Second Table -->
                    <table>
                        <tbody>
                            <!-- Amount -->
                            <tr>
                                <td class="pb-2">Amount:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php
                                    echo isset($order['billed_amount'])
                                        ? '$' . number_format($order['billed_amount'], 2)
                                        : '—';
                                    ?>
                                </th>
                            </tr>
                            <!-- Submitted -->
                            <tr>
                                <td class="pb-2">Submitted:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    Exhibit count: <?php echo htmlspecialchars($order['exhibit_count'] ?? '0'); ?>
                                    <span class="separator"> | </span>
                                    Page count: <?php echo htmlspecialchars($order['page_count'] ?? '0'); ?>
                                </th>
                            </tr>
                            <!-- Defendant First Name -->
                            <tr>
                                <td class="pb-2">Defendant First name:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['defendant_first_name'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Defendant Last Name -->
                            <tr>
                                <td class="pb-2">Defendant Last name:</td>
                                <th class="text-end pb-2 fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['defendant_last_name'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Defendant Company Name -->
                            <tr>
                                <td class="pb-2">Defendant Company Name:</td>
                                <th class="text-end fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['defendant_company_name'] ?? '—'); ?>
                                </th>
                            </tr>
                            <!-- Date of Incident -->
                            <tr>
                                <td class="pb-2">DOI (Date of Incident):</td>
                                <th class="text-end fw-semibold" scope="row">
                                    <?php
                                    if (!empty($order['date_of_incident']) && $order['date_of_incident'] !== '0000-00-00') {
                                        echo date('m-d-Y', strtotime($order['date_of_incident']));
                                    } else {
                                        echo '—';
                                    }
                                    ?>
                                </th>
                            </tr>
                            <!-- Location of Accident -->
                            <tr>
                                <td>LOA (Location of Accident):</td>
                                <th class="text-end fw-semibold" scope="row">
                                    <?php echo htmlspecialchars($order['location_of_accident'] ?? '—'); ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php 
            if(isset($order['claim_type']) && $order['claim_type']=='bodily_injury'):
                // Split injury areas string into an array
                $injuryAreas = explode(',', $order['injury_areas']);
            
                // get injury details for each type
                $injuryDetails = getInjuryDetailsList();

                // Split injury areas string into an array
                $injuryAreas = explode(',', $order['injury_areas']);

                // Iterate through each injury and render HTML
                foreach ($injuryAreas as $injury) {
                    $injury = trim($injury); // Ensure no extra spaces
                    if (!isset($injuryDetails[$injury])) continue; // Skip if details aren't defined

                    $details = $injuryDetails[$injury];
                    echo '<p class="mb-2 fw-medium">' . htmlspecialchars($details['title']) . '</p>';

                    // Components if available
                    if (isset($details['components'])) {
                        echo '<p><span class="text-main-blue fw-medium">Components:</span> ' . htmlspecialchars($details['components']) . '</p>';
                    }

                    // Musculoskeletal if available
                    if (isset($details['musculoskeletal'])) {
                        echo '<p><span class="text-main-blue fw-medium">Musculoskeletal:</span> ' . htmlspecialchars($details['musculoskeletal']) . '</p>';
                    }

                    // Description if available
                    if (isset($details['description'])) {
                        echo '<p>' . htmlspecialchars($details['description']) . '</p>';
                    }

                    echo '<hr>';
                }
            ?>
            <?= $this->setData([ 'injuryAreas' => $injuryAreas,] )->include('Cases/injury-areas-'.$order['plaintiff_gender']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>