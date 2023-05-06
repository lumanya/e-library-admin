<?php

use Illuminate\Database\Seeder;

class StaticDataTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('static_data')->delete();
        
        \DB::table('static_data')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 'language',
                'value' => 'Hindi',
                'label' => 'Hindi',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 'language',
                'value' => 'English',
                'label' => 'English',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 'language',
                'value' => 'Gujarati',
                'label' => 'Gujarati',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'type' => 'language',
                'value' => 'Hindi-English',
                'label' => 'Hindi-English',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'type' => 'language',
                'value' => 'Bengali',
                'label' => 'Bengali',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'type' => 'language',
                'value' => 'Marathi',
                'label' => 'Marathi',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'type' => 'language',
                'value' => 'Telugu',
                'label' => 'Telugu',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'type' => 'language',
                'value' => 'Tamil',
                'label' => 'Tamil',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'type' => 'language',
                'value' => 'Urdu',
                'label' => 'Urdu',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'type' => 'language',
                'value' => 'Kannada',
                'label' => 'Kannada',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'type' => 'language',
                'value' => 'Odia',
                'label' => 'Odia',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'type' => 'language',
                'value' => 'Malayalam',
                'label' => 'Malayalam',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'type' => 'language',
                'value' => 'Panjabi',
                'label' => 'Panjabi',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'type' => 'language',
                'value' => 'Sanskrit',
                'label' => 'Sanskrit',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'type' => 'checkmark',
                'value' => '100% Genuine Product',
                'label' => '100% Genuine Product',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'type' => 'checkmark',
                'value' => 'Secure Ordering',
                'label' => 'Secure Ordering',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'type' => 'checkmark',
                'value' => 'days_replacement',
                'label' => 'Days Replacement Guarantee',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'type' => 'checkmark',
                'value' => 'request_callback',
                'label' => 'Request a Call Back',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'type' => 'checkmark',
                'value' => 'cash_on_delivery',
                'label' => 'Cash On Delivery',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'type' => 'checkmark',
                'value' => 'Self-Placed Learning',
                'label' => 'Self-Placed Learning',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'type' => 'formate',
                'value' => 'pdf',
                'label' => 'PDF',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'type' => 'formate',
                'value' => 'epub',
                'label' => 'EPUB',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'type' => 'upload_file_format',
                'value' => 'apk',
                'label' => 'APK',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'type' => 'upload_file_format',
                'value' => 'exe',
                'label' => 'EXE',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}