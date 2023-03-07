<?php
namespace App\Helpers;

class KeyHelper{

    public static function Type(){
        return [
            //group and type
            KeyHelper::Finalise(),
            KeyHelper::Status(),
            KeyHelper::Transaction(),
            KeyHelper::Character(),
            KeyHelper::Totaliser(),
            KeyHelper::Menu()
        ];
    }

    public static function Count(){
        $countArray = 
            //group and type
            count(KeyHelper::Finalise()) +
            count(KeyHelper::Status()) +
            count(KeyHelper::Transaction()) +
            count(KeyHelper::Character()) +
            count(KeyHelper::Totaliser()) +
            count(KeyHelper::Menu()) ;
        

        return $countArray;
    }

    public static function Status(){
        return [
            
            'NO FUNCTION',
            'AUTO CLERK',
            'BATCH REPORT',
            'BREAK IN',
            'BREAK OUT',
            'CALLER ID',
            'CASH DECLARE',
            'CASH DECLARE 2',
            'CATEGORY SHIFT',
            'CLEAN SCREEN',
            'CLERK CHANGE',
            'CLERK FUNCTIONS',
            'CLERK NUMBER',
            'CLOCK IN',
            'CLOCK OUT',
            'CLOSE DOWN TILL',
            'COVERS',
            'CREDIT CARD CAPTURE',
            'CURRENCY EXCHANGE',
            'CUSTOMER BIOMETRICS',
            'CUSTOMER HOT CARD',
            'CUSTOMER INQUIRY',
            'CUSTOMER NUMBER',
            'CUSTOMER TRANSFER',
            'DATA BACKUP/RESTORE',
            'DEFER',
            'DOWNLOAD GRAPHIC LOGO',
            'DUTCH BILL PRINT',
            'EAT IN',
            'EDIT CHECK TEXT',
            'EDIT CUSTOMER',
            'EDIT FLOOR PLAN',
            'ENABLE TAX',
            'ESCAPE',
            'EURO SHIFT',
            'FIDELITY LOYALTY CARD',
            'FLOOR PLAN',
            'GIFT RECEIPT',
            'GLOBAL EAT IN/TAKE OUT',
            'GRAPHIC KP MESSAGE',
            'HOME MODE',
            'INLINE BATCH REPORT',
            'INLINE FUNCTIONS',
            'INLINE PERIOD 1 REPORT',
            'INLINE PERIOD 2 REPORT',
            'INLINE PERIOD 3 REPORT',
            'LAUNCH BATCH FILE',
            'LIST PLU',
            'LOCATION',
            'LOCK TERMNAL',
            'MANAGER FUNCTIONS',
            'MENU LEVEL SHIFT',
            'MENU SHIFT 2',
            'MINIMZE ICRTOUCH',
            'MULTIPLY',
            'NEW CHECK',
            'NEW/OLD CHECK',
            'NON-ADD NUMBER (#)',
            'OLD CHECK',
            'ORDER NUMBER',
            'PERIOD 1 REPORTS',
            'PERIOD 2 REPORTS',
            'PERIOD 3 REPORTS',
            'PLAY MACRO',
            'PLU GROUP SEARCH',
            'PLU NOTES INQUIRY',
            'PLU NUMBER',
            'PLU PICTURE INQUIRY',
            'PLUSITEM',
            'PRESET TEXT MESSAGE',
            'PRICE INQUIRY',
            'PRICE LEVEL CHANGE',
            'PRICE SHIFT',
            'PROGRAM MODE',
            'RECEIPT ON/OFF',
            'RECEIPT PRINT',
            'RECEIVE PROGRAM',
            'REFUND MODE',
            'REG MODE',
            'REG WIN DOWN ARROW',
            'REG WIN UP ARROW',
            'REMOTE JOURNAL VIEW',
            'RESUME',
            'RUN SCRIPT',
            'SALE ITEM IMPORT',
            'SEAT NUMBER',
            'SEND PROGRAM',
            'SEND TO KP NOW',
            'SERVICE CHARGE',
            'SET MENU SHIFT',
            'SIGN OFF',
            'SLIP PRINT',
            'SPLIT CHECK',
            'STOCK INQUIRY',
            'SUBTOTAL',
            'SUSPEND',
            'TABLE RESERVATION',
            'TAKE OUT',
            'TEXT MESSAGE',
            'VALIDATION',
            'VIEW ACTIVE CLERKS',
            'VIEW CUSTOMER DETAIL',
            'VIEW JOURNAL',
            'VIEW OPEN CHECKS',
            'VIEW PAID CHECKS',
            'VIEW RECEIPTS',
            'VIEW REPORTS',
            'VIEW WEBSALES',
            'WEIGHT',
            'X/Z MODE',
        ];
    }

    public static function Finalise(){
        return [
            'NO FUNCTION',
            'ACCOUNT',
            'CASH',
            'CHEQUE',
            'EFT',//electronic fund transfer
            'HOTEL TRANSFER',
            'VOUCHER'
        ];
    }

    public static function Transaction(){
        return [
            'NO FUNCTION',
            '- AMOUNT',
            '- %',
            '+ AMOUNT',
            '+ %',
            'CANCEL',
            'CHECK TRANSFER',
            'DEPOSIT',
            'EFT PREAUTH',
            'ERROR CORRECT',
            'EXCHANGE POINTS',
            'HOUSE BON',
            'MEDIA EXCHANGE',
            'NEW BALANCE',
            'NO SALE',
            'PAID OUT',
            'PAY ACCOUNT',
            'POINTS ADJUSTMENT',
            'PRICE CHANGE',
            'REASON TABLE',
            'RECEIVED ON ACCOUNT',
            'REFUND',
            'TIPS',
            'VOUCHER',
            'DELIVERY'
        ];
    }

    public static function Character(){
        return [
            'NO FUNCTION',
            'Half',
            'Dbl',
            'Device 1',
            '+ AMOUNT',
            'Device 2',
            'Device 3',
            '1*  2*  3*  4*',
            '5*  6*  7*  8*  9*  10*',
            'REG',
            'REFUND',
            'X1',
            'Z1',
            'MANAGER',
            'HOME',
            'Prices',
            'Texts'
        ];
    }

    public static function Totaliser(){
        return [
            'NO FUNCTION',
            'NET sales',
            'Dbl',
            'GROSS Sales',
            'CASH in Drawer',
            'CHEQUE in Drawer',
            'CREDIT in Drawer',
            'Account Sales',
            'BACs Payment',
            'DRAWER',
            'TOTAL DRAWER',
            'TRAINING MODE',
            'REFUND MODE',
            'REFUND/VOID'
        ];
    }

    public static function Menu(){
        return [
            
        ];
    }
}