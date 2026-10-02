<?php

class db {

    const host = 'localhost';
    const dbName = 'cub';
    const user = 'root';
    const password = '';

    /*     * ****************************************************************************** */
    /*     * ***********************************LOG************************************* */
    /*     * ****************************************************************************** */

    static function exec($sql) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->exec($sql);
        $error = 0;
        if ($req == false)
            self::addLog(addslashes($sql), 1);
        self::addLog(addslashes($sql), 0);
        $bdd = null;
        return $req;
    }

    static function addLog($request, $error) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $dateAdd = new DateTime();
        $dateAdd = $dateAdd->format('Y-m-d H:i:s');
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'DIGI-ONE';
        $req = $bdd->exec("insert into log(request, user_name, date_add, error) values('" . $request . "', '" . $userName . "','" . $dateAdd . "', " . $error . ")");
        $req = $bdd->query("select max(id_log) as id_log from log");
        $data = $req->fetch();
        return $data['id_log'];
    }

    static function validateUser($email, $password) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from user  where email='" . $email . "' and password='" . $password . "'");
        return $req->fetch();
    }

    static function getUsers() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select *
                            from user u ");
        return $req->fetchAll();
    }

    static function getUserByName($name) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from user where name='" . $name . "'");
//        echo($name);exit;
        return $req->fetch();
    }

    static function getFabForm($idFabForm) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from fab_form where id_fab_form=" . $idFabForm);
        // Vérifiez si la requête a réussi
        if ($req !== false) {
            // Utilisez fetch() pour récupérer une seule ligne
            return $req->fetch();
        } else {
            // Gérez l'erreur ici, par exemple en renvoyant une valeur par défaut
            return null;
        }
    }

    static function getCustomer($idCustomer) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from customer where id_customer=" . $idCustomer);
        return $req->fetch();
    }

    static function getOfs($customerName, $filterOrderDateStart, $filterOrderDateenlevement, $filterOrderWeekFab, $filtercde, $filterRef, $filterDateCommande, $filterStatut) {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $_SESSION['filter_customer_name'] = $customerName;
        $_SESSION['filter_order_date_start'] = $filterOrderDateStart;
        $_SESSION['filter_order_date_enlevement'] = $filterOrderDateenlevement;
        $_SESSION['filter_order_week_fab'] = $filterOrderWeekFab;
        $_SESSION['filter_cde'] = $filtercde;
        $_SESSION['filter_ref'] = $filterRef;
        $_SESSION['filter_date_commande'] = $filterDateCommande;
        $_SESSION['filter_status'] = $filterStatut;
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);

        $filter = "";
        if ($customerName) {
            $filter .= " and c.name like '%" . $customerName . "%'";
        }

        if ($filterOrderDateStart) {
            $filter .= " and shipping_date='" . $filterOrderDateStart . " 00:00:00' ";
        }
        if ($filterOrderDateenlevement) {
            $filter .= " and removal_date='" . $filterOrderDateenlevement . " 00:00:00' ";
        }
        if ($filterOrderWeekFab) {
            $filter .= " and sfab='" . $filterOrderWeekFab . " 00:00:00' ";
        }
        if ($filterRef) {
            $filter .= " and reference like '%" . $filterRef . "%'";
        }

        if ($filtercde) {
            $filter .= " and id_order like '%" . $filtercde . "%'";
        }
        if ($filterStatut) {
            $filter .= " and status like '%" . $filterStatut . "%'";
        }
        if ($filterDateCommande) {
            $filter .= " and date_commande='" . $filterDateCommande . " 00:00:00' ";
        }

        $sql = "SELECT *
                         FROM fab_form ff
                         INNER JOIN customer c USING(id_customer)
                         WHERE 1
                             " . $filter . ";";

//        echo $sql;
//        exit;

        $req = $bdd->query($sql);
        return $req->fetchAll();
    }

    static function getCustomers($customerName) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $filter = "";
        if ($customerName) {
            $filter .= " and (c.name like '%" . $customerName . "%' OR c.code like '%" . $customerName . "%')";
        }
        $sql = "SELECT * 
                            FROM customer c 
                            WHERE 1
                            " . $filter . ";";

        $req = $bdd->query($sql);

        return $req->fetchAll();
    }

    static function getStatus() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `status` ");
        return $req->fetchAll();
    }

//    static function getSfabs() {
//        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
//        $req = $bdd->query("SELECT * FROM `sfab` ");
//        return $req->fetchAll();
//    }
//
//    static function getSembs() {
//        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
//        $req = $bdd->query("SELECT * FROM `semb` ");
//        return $req->fetchAll();
//    }

    static function getparamTeintTypes() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `param_teint_type` ");
        return $req->fetchAll();
    }

    static function addparamTeintType($value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert into param_teint_type(value) values('" . $value . "')";
        self::exec($sql);
        return 1;
    }

    static function deleteparamTeintType($id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete from param_teint_type where id_param_teint_type=" . $id;
        self::exec($sql);
        return 1;
    }

    static function getParamTeintCodes() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `param_teint_code` ");
        return $req->fetchAll();
    }

    static function addParamTeintCode($value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert into param_teint_code(value) values('" . $value . "')";
        self::exec($sql);
        return 1;
    }

    static function deleteParamTeintCode($id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete from param_teint_code where id_param_teint_code =" . $id;
        self::exec($sql);
        return 1;
    }

    static function getParamTeintText1s() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `param_teint_text_1` ");
        return $req->fetchAll();
    }

    static function addParamTeintText1($value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert into param_teint_text_1(value) values('" . $value . "')";
        self::exec($sql);
        return 1;
    }

    static function deleteParamTeintText1($id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete from param_teint_text_1 where id_param_teint_text_1 =" . $id;
        self::exec($sql);
        return 1;
    }

    static function getParamTeintText2s() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `param_teint_text_2` ");
        return $req->fetchAll();
    }

    static function addParamTeintText2($value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert into param_teint_text_2(value) values('" . $value . "')";
        self::exec($sql);
        return 1;
    }

    static function deleteParamTeintText2($id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete from param_teint_text_2 where id_param_teint_text_2 =" . $id;
        self::exec($sql);
        return 1;
    }

    static function getParamPrepas() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `param_prepa` ");
        return $req->fetchAll();
    }

    static function addParamPrepa($value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert into param_prepa(value) values('" . $value . "')";
        self::exec($sql);
        return 1;
    }

    static function deleteParamPrepa($id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete from param_prepa where id_param_prepa=" . $id;
        self::exec($sql);
        return 1;
    }

    static function getParamEmbals() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("SELECT * FROM `param_embal` ");
        return $req->fetchAll();
    }

    static function addParamEmbal($value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert into param_embal(value) values('" . $value . "')";
        self::exec($sql);
        return 1;
    }

    static function deleteParamEmbal($id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete from param_embal where id_param_embal =" . $id;
        self::exec($sql);
        return 1;
    }

    static function createEmptyFabForm() {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['cub_user_name']) ? $_SESSION['cub_user_name'] : 'DIGI-ONE';
        $sql = "insert into fab_form(user_add) values('" . $userName . "')";
        $req = self::exec($sql);
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select max(id_fab_form) as id_fab_form from fab_form");
        $data = $req->fetch();
        return $data['id_fab_form'];
    }

    static function createEmptyReception() {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['cub_user_name']) ? $_SESSION['cub_user_name'] : 'DIGI-ONE';
        $sql = "insert into reception(user_add) values('" . $userName . "')";
        $req = self::exec($sql);
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select max(id_reception) as id_reception from reception");
        $data = $req->fetch();
        return $data['id_reception'];
    }

    static function getReception($idReception) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from reception where id_reception=" . $idReception);
        return $req->fetch();
    }

    static function getReceptions() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select r.*, c.name, count(rr.id_reception_receipt) as nb_receipt
                            from reception r 
                            left join reception_receipt rr using(id_reception)
                            inner join customer c using(id_customer)
                            group by r.id_reception;");
        return $req->fetchAll();
    }

    static function getFabFormReceiptWaiting($idReception) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);

        $reception = self::getReception($idReception);

        $fabforms = array();

        if ($reception['reception_status'] == 'En cours') {
            $sql = "SELECT *
                FROM fab_form ff
                INNER JOIN customer c USING(id_customer)
                WHERE status = 'En attente de réception'
                and id_customer = " . $reception['id_customer'] . ";";

            $req = $bdd->query($sql);

            $waitingFabforms = $req->fetchAll();

            foreach ($waitingFabforms as $waitingFabform)
                $fabforms[] = $waitingFabform;
        }

        $sql = "SELECT *
                FROM fab_form ff
                INNER JOIN customer c USING(id_customer)
                INNER JOIN reception_receipt rr USING(id_fab_form)
                WHERE id_reception = " . $idReception . ";";

        $req = $bdd->query($sql);

        $otherFabforms = $req->fetchAll();
        foreach ($otherFabforms as $otherFabform)
            $fabforms[] = $otherFabform;

        return $fabforms;
    }

    static function updateFieldfabForm(
            $idFabForm, $field, $value, $type, $oldValue) {
        $oldValue = addslashes($oldValue);
        $value = addslashes($value);
        $sql = "";
        if ($type == 'varchar' || $type == 'datetime')
            $sql = "    update fab_form set " . $field . " = '" . $value . "' where id_fab_form = " . $idFabForm
            ;
        else
            $sql = "update fab_form set " . $field . " = " . $value . " where id_fab_form = " . $idFabForm;
        self::exec($sql);
        self::addHistory($idFabForm, $field, $value, $oldValue);
        return 1;
    }

    static function saveFabFormElement(
            $idFabForm, $elements, $elementsSup) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);

        // Suppression des éléments existants pour l'id_fab_form donné
        $deleteSql = "  DELETE  FROM fab_form_element WHERE id_fab_form = $idFabForm";
        $bdd->exec($deleteSql);
        // Insertion des nouveaux éléments
        foreach ($elements as $idElement => $element) {
            $insertSql = "INSERT INTO fab_form_element (id_fab_form, id_element, value, livr, finition, comment) VALUES (" . $idFabForm . ", " . $idElement . ", " . intval($element['value']) . ", " . intval($element['livr']) . ", " . intval($element['finition']) . ", '" . $element['comment'] . "' ) ";
            $bdd->exec($insertSql);
        }
        foreach ($elementsSup as $element) {
            $insertSql = "INSERT INTO fab_form_element (id_fab_form, name, value, livr, finition, comment) VALUES (" . $idFabForm . ", '" . $element['name'] . "', " . intval($element['value']) . ", " . intval($element['livr']) . ", " . intval($element['finition']) . ", '" . $element['comment'] . "' ) ";
//            echo $insertSql;exit;
            $bdd->exec($insertSql
            );
        }
    }

    static function getElements() {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from element order by position asc");
        return $req->fetchAll();
    }

//    static function getElementsSup() {
//        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
//        $req = $bdd->query("SELECT * FROM champ_sup");
//        if ($req === false) {
//            // Gestion de l'erreur de requête
////            // Vous pouvez afficher un message d'erreur, enregistrer des journaux, etc.
////            // Vous pouvez également retourner false ou un tableau vide selon vos besoins
//            die(print_r($bdd->errorInfo(), true));
//        }
//        return $req->fetchAll();
//    }
//        if ($req === false) {
//            // Gestion de l'erreur de requête
//            // Vous pouvez afficher un message d'erreur, enregistrer des journaux, etc.
//            // Vous pouvez également retourner false ou un tableau vide selon vos besoins.
//            die(print_r($bdd->errorInfo(), true));
//        }
//    static function saveFabFormChampSup($idFabForm, $elementsSups) {
//        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
//
//// Suppression des éléments existants pour l'id_fab_form donné
//        $deleteSql = "DELETE FROM champ_sup WHERE id_fab_form = $idFabForm";
//        $bdd->exec($deleteSql);
//// Insertion des nouveaux éléments
//        foreach ($elementsSups as $idElement => $elementsSup) {
//            $insertSql = "INSERT INTO champ_sup (id_fab_form, id_element, valu, livra, finition, comment) VALUES (" . $idFabForm . ", " . $idElement . ", " . intval($elementsSup['value']) . ", " . intval($elementsSup['livraison']) . ", " . intval($elementsSup['finition']) . ", '" . $elementsSup['comment'] . "')";
//            echo $insertSql . "<br>";
//            $bdd->exec($insertSql
//        );
//        }
//    }

    static function addElement($name) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "insert  into element(name)values('" . $name . "' ) ";
        self::exec($sql);
        return 1;
    }

    static function deleteElement(
            $id) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "delete  from element where id_element = " . $id;
        self::exec($sql);
        return 1;
    }

    static function getItems() {


        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from item");
        return $req->fetchAll();
    }

    static function getItemsElements() {


        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from item_element");

        $itemsElements = $req->fetchAll();
        $result = array();

        foreach ($itemsElements as $itemElement)
            $result[$itemElement['id_item'] . '-' . $itemElement['id_element']] = $itemElement['value'];

        return $result;
    }

    static function addItemElement(
            $idItem, $idElement, $value) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "  delete  from item_element where id_item = " . $idItem . " and id_element = " . $idElement;
        self::exec($sql);
        $sql = "insert into item_element (id_item, id_element, value)values(" . $idItem . ", " . $idElement . ", " . $value . ")";
        self::exec($sql
        );
    }

    static function getElementsForFabForm($idFabForm) {

        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "SELECT  * FROM fab_form_element ffe
                INNER JOIN element e USING (id_element)
                where id_fab_form = " . $idFabForm . "
                and id_element is not null
                order by position;
                ";
        $req = $bdd->query($sql);
        return $req->fetchAll();
    }

    static function getElementsSupForFabForm(
            $idFabForm) {

        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "SELECT  ffe.*
                FROM fab_form_element ffe
                left JOIN element e USING (id_element)
                where id_fab_form = " . $idFabForm . "
                and id_element is null
                order by position;
                ";

        $req = $bdd->query($sql);
        return $req->fetchAll();
    }

    static function generateElementsForFabForm(
            $idFabForm) {

        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);

        $sql = "SELECT  e.id_element, e.name, sum(ie.value*ffi.quantity) as value
                from fab_form ff
                inner join fab_form_item ffi using(id_fab_form)
                inner join item_element ie using(id_item)
                inner join element e using(id_element)
                where id_fab_form = " . $idFabForm . "
                group by e.id_element
                order by position;
                ";
        $req = $bdd->query($sql);

        $sql = "delete from fab_form_element where id_fab_form = " . $idFabForm . " and name is null";
        self::exec($sql);

        $elements = $req->fetchAll();
        foreach ($elements as $element) {
            $sql = "insert into fab_form_element (id_fab_form, id_element, value)values(" . $idFabForm . ", " . $element['id_element'] . ", " . $element['value'] . ")";
            self::exec($sql
            );
        }
    }

    static function getItemsForFabForm($idFabForm) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "select  id_fab_form, i.family, i.reference, i.name, i.sell_unity, ffi.quantity
                from fab_form ff
                inner join fab_form_item ffi using(id_fab_form)
                inner join item i using(id_item)
                where id_fab_form = " . $idFabForm . ";
                ";
        $req = $bdd->query($sql);
        return $req->fetchAll();
    }

    static function getTicketReasons() {
        try {


            $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
            $req = $bdd->query("select * from ticket_reason");

            if ($req === false) {
                // Gestion de l'erreur
                $errorInfo = $bdd->errorInfo();
                throw new Exception("Erreur lors de l'exécution de la requête SQL: " . $errorInfo[2]);
            }

            return $req->fetchAll();
        } catch (Exception $e) {
            // Gestion de l'exception
            echo "Erreur: " . $e->getMessage();
            return array(); // Ou une autre valeur par défaut selon votre besoin
        }
    }

    static function getTickets($all = 0, $idfabform = 0) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['cub_user_name']) ? $_SESSION['cub_user_name'] : 'DIGI-ONE';

        $filter = "";
        if ($all == 0)
            $filter = " and (u1.name='" . $userName . "' or u2.name='" . $userName . "') ";
        if ($idfabform)
            $filter .= " and t.id_fab_form=" . $idfabform . " ";

        $return = array();

        $statuses = array('Ouvert', 'Fermé');
        foreach ($statuses as $status) {
            $sql = "select t.*, u1.name, (u2.name) as destinataires, c.name 
                from ticket t 
                left join ticket_user tu1 on t.id_ticket=tu1.id_ticket
                left join user u1 on tu1.id_user=u1.id_user
                left join ticket_user tu2 on t.id_ticket=tu2.id_ticket 
                left join user u2 on tu2.id_user=u2.id_user
                inner join fab_form o using(id_fab_form)
                left join customer c using(id_customer)
                where t.status='" . $status . "' 
                and tu1.is_creator=1
                and tu2.is_creator=0
                " . $filter . "
                group by t.id_ticket
                order by id_ticket desc;";
//            echo $sql;exit;
            $req = $bdd->query($sql);
            $tickets = $req->fetchAll();
            foreach ($tickets as $ticket)
                $return[] = $ticket;
        }
        return $return;
    }

    static function getTicket($idTicket) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select t.*, u.name
                            from ticket t
                            inner join ticket_user tu using(id_ticket)
                            inner join user u using(id_user)
                            where id_ticket=" . $idTicket . "
                            and tu.is_creator=1;");
        // Vérifiez si la requête a réussi
        if ($req !== false) {
            // Utilisez fetch() pour récupérer une seule ligne
            return $req->fetch();
        } else {
            // Gérez l'erreur ici, par exemple en renvoyant une valeur par défaut
            return null;
        }
    }

    static function getTicketUsers($idTicket) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select group_concat(u.name) as users
                            from ticket_user tu 
                            inner join user u using(id_user)
                            where id_ticket=" . $idTicket . "
                            and tu.is_creator=0
                            group by tu.id_ticket;");
        // Vérifiez si la requête a réussi
        if ($req !== false) {
            // Utilisez fetch() pour récupérer une seule ligne
            return $req->fetch();
        } else {
            // Gérez l'erreur ici, par exemple en renvoyant une valeur par défaut
            return null;
        }
    }

    static function getTicketCreator($idTicket) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select u.name 
                            from ticket_user tu 
                            inner join user u using(id_user)
                            where id_ticket=" . $idTicket . "
                            and tu.is_creator=1
                            group by tu.id_ticket;");
        // Vérifiez si la requête a réussi
        if ($req !== false) {
            // Utilisez fetch() pour récupérer une seule ligne
            return $req->fetch();
        } else {
            // Gérez l'erreur ici, par exemple en renvoyant une valeur par défaut
            return null;
        }
    }

    static function getTicketResponses($idTicket) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select tr.response, tr.date_add, u.name as user_name
                            from ticket_response tr 
                            left join user u using(id_user)
                            where tr.id_ticket=" . $idTicket . "
                            order by tr.id_response asc;");
        // Vérifiez si la requête a réussi
        if ($req !== false) {
            // Utilisez fetch() pour récupérer une seule ligne
            return $req->fetch();
        } else {
            // Gérez l'erreur ici, par exemple en renvoyant une valeur par défaut
            return null;
        }
    }

    static function createTicket($idFabForm, $title, $comment, $reasonName, $idUser) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'DIGI-ONE';
        $stmt = $bdd->prepare("INSERT INTO ticket (id_fab_form, title, comment,reason_name) VALUES (?, ?, ?,?)");
        $stmt->execute([$idFabForm, $title, $comment, $reasonName]);
        $lastInsertedId = $bdd->lastInsertId();
        $stmt = $bdd->prepare("INSERT INTO ticket_user (id_ticket, id_user, seen, is_creator) VALUES (?, ?, 1, 1)");
        $stmt->execute([$lastInsertedId, $idUser]);
        return $lastInsertedId;
    }

    static function seeTicket($id_ticket) {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'DIGI-ONE';
        $user = db::getUserByName($userName);
        $id_user = $user['id_user'];
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $bdd->exec("update ticket_user set seen = 1 where id_user = " . $id_user . " and id_ticket = " . $id_ticket);
        return '';
    }

    static function createTicketUser($idTicket, $idUser) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = self::exec("insert into ticket_user(id_ticket, id_user, seen, is_creator) values(" . $idTicket . ", $idUser, 0, 0)");
        return 1;
    }

    static function createTicketResponse($idTicket, $response) {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'DIGI-ONE';
        $user = db::getUserByName($userName);
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = self::exec("insert into ticket_response(id_ticket, response, id_user)values(" . $idTicket . ",'" . addslashes($response) . "'," . $user['id_user'] . ")");
        $req = $bdd->exec("update ticket_user set seen=0 where id_user<>" . $user['id_user'] . " and id_ticket=" . $idTicket);
        return 1;
    }

    static function closeTicket($idTicket) {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'DIGI-ONE';
        $user = db::getUserByName($userName);
        $today = new DateTime();
        $today = $today->format('Y-m-d H:i:s');
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = self::exec("update ticket set status='Fermé', id_close_user=" . $user['id_user'] . ", close_date='" . $today . "' where id_ticket=" . $idTicket);
        return 1;
    }

    static function getNoSeenTickets() {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'DIGI-ONE';
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);

        $sql = "select t.id_ticket
from ticket t
left join ticket_user tu on t.id_ticket = tu.id_ticket
left join user u using(id_user)
where (u.name = '" . $userName . "' and tu.seen = 0)
group by t.id_ticket
order by t.status desc, t.id_ticket desc;
";

        $req = $bdd->query($sql);
        $tickets = $req->fetchAll();

        $data = array();
        foreach ($tickets as $ticket)
            $data[] = $ticket['id_ticket'];

        return $data;
    }

    static function getUserById($idUser) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $req = $bdd->query("select * from user where id_user=" . $idUser . "");
        return $req->fetch();
    }

    static function addHistory($idFabForm, $field, $value, $oldValue) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['cub_user_name']) ? $_SESSION['cub_user_name'] : 'DIGI-ONE';
        $oldValue = addslashes($oldValue);
        $sql = "insert into history (id_fab_form, user_add, field, old_value, new_value)values(" . $idFabForm . ",'" . $userName . "', '" . $field . "','" . $oldValue . "','" . $value . "');";
        $req = $bdd->exec($sql);
        return 1;
    }

    static function getHistories($idFabForm) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "SELECT DATE(h.date_add) AS date_add, CONCAT(LPAD(HOUR(h.date_add), 2, '0'), ':', LPAD(MINUTE(h.date_add), 2, '0'), ':', LPAD(SECOND(h.date_add), 2, '0')) AS hour_add, h.field, h.old_value, h.new_value, h.user_add FROM history h WHERE id_fab_form = " . $idFabForm . " ORDER BY id_history DESC";
        $req = $bdd->query($sql);
//        echo($sql);exit;
        $data = $req->fetchAll();
        $return = array();
        foreach ($data as $row) {
            if (!isset($return[$row['date_add']]))
                $return[$row['date_add']] = array();
            $return[$row['date_add']][] = $row;
        }
        return $return;
    }

    static function updateReceptionCustomer($idReception, $idCustomer) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "update reception set id_customer=" . $idCustomer . " where id_reception=" . $idReception;
        $req = $bdd->exec($sql);
        return 1;
    }

    static function updateReceptionComment($idReception, $comment) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "update reception set comment='" . $comment . "' where id_reception=" . $idReception;
        $req = $bdd->exec($sql);
        return 1;
    }

    static function validateReception($idReception) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        $sql = "update reception set reception_status='Validé' where id_reception=" . $idReception;
        $req = $bdd->exec($sql);
        return 1;
    }

    static function addReceptionReceipt($idReception, $idFabform) {
        $bdd = new PDO('mysql:host=' . self::host . ';dbname=' . self::dbName . ';charset=utf8', self::user, self::password);
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $userName = isset($_SESSION['cub_user_name']) ? $_SESSION['cub_user_name'] : 'DIGI-ONE';
        $sql = "insert into reception_receipt (id_reception, id_fab_form, user_receipt)values(" . $idReception . "," . $idFabform . ",'" . $userName . "')";
        $req = $bdd->exec($sql);
        return 1;
    }

}
