<?php

class api_loop {
    private $apikeys;
    private $apikeys_copy;
    private $data_array;
    private $results;
    private $pauseSeconds = 5;
    private $type;

    public function __construct($data_array, $type) {
        $db_request_api = new db_request();
        $this->apikeys = $db_request_api->getAllWorkingRawAPIKeys();
        $this->data_array = $data_array;
        $this->type = $type;
    }

    public function processData() {
        $this->apikeys_copy = $this->apikeys;

        foreach ($this->data_array as $index => $data_point) {
            $this->processDataWithAPIKeys($data_point, $index);
        }

        // Return or access results array after processing all data_points
        return $this->results;
    }


    private function processDataWithAPIKeys($data_point, $indx = null) {
        do {
            foreach ($this->apikeys_copy as $index => $apiKey) {
                try {
                    unset($this->apikeys_copy[$index]); // Remove the used API key from this copy always
                    
                    // Now try to use it
                    switch ($this->type) {
                        case 'getFactionMembersStats':
                            // Pull data using the API key for the member
                            $api_request = new api_request($apiKey, $index);
                            $memberdata = $api_request->getPlayerPersonalStats($data_point['tornID']);
                            $this->results[$data_point['tornID']] = $memberdata; // Store the result
                            return;
                        break;

                        case 'factionLookup':
                            // Pull data using the API key for the member
                            $api_request = new api_request($apiKey, $index);
                            $lookupdata = $api_request->getPlayerPersonalStats($indx);
                            $this->results[$indx] = $lookupdata; // Store the result
                            return;
                        break;
                        
                        default:
                            exit('ERROR with loop type');
                        break;
                    }
    
                } catch (Exception $e) {
                    // Handle the error and remove the faulty API key
                    unset($this->apikeys[array_search($apiKey, $this->apikeys)]);
                    continue; // Continue to the next API key
                }
            }
            // If all keys fail, exit
            if (empty($this->apikeys)) {
                exit("No API keys left, stopping process."); // Exit the function if no API keys are left
            }

            if (empty($this->apikeys_copy)) {
                $this->apikeys_copy = $this->apikeys; // Reset API keys for next data iteration
                sleep($this->pauseSeconds); // Pause before retrying
            }
        } while (!empty($this->apikeys_copy));
    } 
    
}

?>