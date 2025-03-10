
<?php
$user = auth()->user();

$reportText = '';
switch ($order['report_type']) {
    case 'medical_chronology':
        $reportText = 'Medical Chronology';
        break;
    case 'billing_summary':
        $reportText = 'Billing Summary';
        break;
    case 'medical_chronology_and_billing_summary':
        $reportText = 'Medical Chronology + Billing Summary';
        break;
    default:
        $reportText = 'Unknown Report Type'; // Optional fallback for unexpected values
        break;
}
?>

<section class="medical-chronology-review">
    <div class="d-flex align-items-center justify-content-between mt-2">
        <h1>Review <?=$reportText?> Order</h1>
        <p>Order ID: <?php echo htmlspecialchars($order['order_number']); ?></p>
    </div>
    <div class="card p-4 rounded-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p>Please thoroughly check and confirm all the details of your submission.</p>
            <p>
                Last Updated: 
                <?php
                // Check if 'updated_at' exists, else use 'time_created'
                $lastUpdated = $order['updated_at'] ?? $order['time_created'] ?? null;
                if ($lastUpdated) {
                    echo date('m-d-Y', strtotime($lastUpdated));
                    echo ' <span class="separator">|</span> ';
                    echo date('g:i A T', strtotime($lastUpdated));
                } else {
                    echo '—';
                }
                ?>
            </p>
        </div>
        <div class="card p-3 bg-main-light border-0 mb-4 rounded-3">
            <div class="d-flex details">
                <table>
                    <tbody>
                        <tr>
                            <td class="pb-2">Claim Number:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row"><?php echo htmlspecialchars($order['claim_number'] ?? '—'); ?></th>
                        </tr>
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
                        <tr>
                            <td class="pb-2">Case name:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row"><?php echo htmlspecialchars($order['case_name'] ?? '—'); ?></th>
                        </tr>
                        <tr>
                            <td class="pb-2">Plaintiff First name:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row"><?php echo htmlspecialchars($order['plaintiff_first_name'] ?? '—'); ?></th>
                        </tr>
                        <tr>
                            <td class="pb-2">Plaintiff Last name:</td>
                            <th class="text-end fw-semibold" scope="row"><?php echo htmlspecialchars($order['plaintiff_last_name'] ?? '—'); ?></th>
                        </tr>
                        <tr>
                            <td class="pb-2">Plaintiff DOB (Date of Birth):</td>
                            <th class="text-end fw-semibold" scope="row">
                                <?php
                                echo isset($order['plaintiff_dob'])
                                    ? date('m-d-Y', strtotime($order['plaintiff_dob']))
                                    : '—';
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td>Plaintiff gender:</td>
                            <th class="text-end fw-semibold" scope="row"><?php echo htmlspecialchars(ucfirst($order['plaintiff_gender'] ?? '—')); ?></th>
                        </tr>
                    </tbody>
                </table>
                <span class="separator-table"></span>
                <table>
                    <tbody>
                        <tr>
                            <td class="pb-2">Amount:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row">
                                <?php
                                
                                echo isset($order['billed_amount']) ? '$' . number_format($order['billed_amount'], 2) : '—';
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td class="pb-2">Submitted:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row">
                                Exhibit count: <?php echo htmlspecialchars($order['exhibit_count'] ?? '0'); ?>
                                <span class="separator">|</span>
                                Page count: <?php echo htmlspecialchars($order['page_count'] ?? '0'); ?>
                            </th>
                        </tr>
                        <tr>
                            <td class="pb-2">Defendant First name:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row"><?php echo htmlspecialchars($order['defendant_first_name'] ?? '—'); ?></th>
                        </tr>
                        <tr>
                            <td class="pb-2">Defendant Last name:</td>
                            <th class="text-end pb-2 fw-semibold" scope="row"><?php echo htmlspecialchars($order['defendant_last_name'] ?? '—'); ?></th>
                        </tr>
                        <tr>
                            <td class="pb-2">Defendant Company Name:</td>
                            <th class="text-end fw-semibold" scope="row"><?php echo htmlspecialchars($order['defendant_company_name'] ?? '—'); ?></th>
                        </tr>
                        <tr>
                            <td class="pb-2">DOI (Date of Incident):</td>
                            <th class="text-end fw-semibold" scope="row">
                                <?php
                                echo isset($order['date_of_incident'])
                                    ? date('m-d-Y', strtotime($order['date_of_incident']))
                                    : '—';
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td>LOA (Location of Accident):</td>
                            <th class="text-end fw-semibold" scope="row"><?php echo htmlspecialchars($order['location_of_accident'] ?? '—'); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
        if(isset($order['claim_type']) && $order['claim_type']=='bodily_injury'):
            // TODO 
            // plaintiff_gender
           // d($order['injury_areas']);
        ?>

        <?php

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
    <div class="d-flex justify-content-end mt-4 gap-3">

        <button class="btn btn-link" id="EditRequest" type="button" aria-label="Edit Request">
            <span>Edit Request</span>
        </button>


        <button class="btn btn-primary" id="ConfirmOrder" type="button" aria-label="Confirm">
            Confirm
        </button>

    </div>
</section>
<?= $this->setData([ 'cardData' => null,] )->include('Checkout/payment-modal') ?>
<script>
    $(document).ready(function() {
        const formSection = $('.js-medical-chronology-request-section');

        $('#EditRequest').on('click', function() {
            formSection.show(); 
            $('.medical-chronology-review').remove();
            // scroll to top
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });

        $('#ConfirmOrder').on('click', function() {

            $('#paymentMethodModal').modal('show');
            
            // const formData = new FormData();
            // formData.append("order_number", $("#medical-chronology-request-order-number").val());

            // $.ajax({
            //     url: `${SITEURL}orders/save-medical-chronology-request`,
            //     type: "POST",
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     headers: {
            //         "X-CSRF-TOKEN": document.querySelector('meta[name="csrf_token"]'), 
            //     },
            //     success: function(response) {
            //         console.log("Form submitted successfully:", response);

            //     },
            //     error: function(xhr, status, error) {
            //         console.error("Form submission failed:", error);
            //     },
            // });
        });
    });

</script>