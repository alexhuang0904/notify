<?php
namespace app;

class ReadFileService {

    public function getList( $fileName )
    {
        $array = [];
        $handle = fopen( $fileName, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                $array[] = explode(',', $line);
            }
            fclose($handle);
        }

        return $this->order2contract($array);
    }

    function order2contract( $orders )
    {
        $contracts = [];
        foreach ($orders as $order)
        {
            $contracts[] = new Contract($order[0], $order[1], $order[2], $order[3], $order[4] );
        }

        return $contracts;
    }
}
