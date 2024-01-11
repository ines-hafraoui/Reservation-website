<?php
$docid = 0;

function echoAPIDoc($title, $URI, $ispost, $payload, $desc, $target) {
    global $docid;
    $payloaddesc = '<strong>GET</strong> request.';
    if ($ispost) {
        $payloaddesc = "<strong>POST</strong> request. Payload is <textarea class='inlinejson'>${payload}</textarea>.";
        $ispost = "true";
    } else {
        $ispost = "false";
    }

    echo <<<EOL
            <details id="doc-${docid}">
                <summary>${title}</summary>
                <br>
                <fieldset>
                    <label for="url">Server</label>
                    <input name="url" type="text" disabled value="${_SERVER['HTTP_HOST']}/api/">
                    <label for="uri">URI</label>
                    <input name="uri" type="text" disabled value="${URI}"><br>
                    <br>
                    <button onclick='request("doc-${docid}",${ispost})'>test API request</button>
                </fieldset>
                <br>
                ${payloaddesc}
                <p>${desc}</p>
                <pre class="target json">${target}</pre>
                <pre class="result json">nothing yet...</pre>
            </details>
EOL;
    $docid++;
}

?>

<section>
    <details open>
        <summary>API documentation and test</summary>
        <details id="doc-${docid}">
            <summary>USER</summary>
            <details id="doc-${docid}">
                <summary>USER : List</summary>
                <?php
                echoAPIDoc('All the listing possible',
                    'user/list',
                    true,
                    '{}',
                    '(?login), (?name), (?first_name), (?email), (?id_role), (?name_class)<br>
                - Select all users<br>
                - Select all users from a class<br>
                - Select all users with same role<br>
                - Select a user by his name<br>
                - Select a user by his first name<br>
                - Select a user by his mail<br>
                - Select a user by his login',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List every users',
                    'user/list',
                    true,
                    '{}',
                    '- Select all users',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List every users in a class',
                    'user/list',
                    true,
                    '{"id_role":1,"name_class":"S1B1"}',
                    '?id_role, ?name_class<br>
                - Select all users from a class<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List every users with the same role',
                    'user/list',
                    true,
                    '{"id_role":1}',
                    '?id_role<br>
                    - Select all users with same role<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List a user by name',
                    'user/list',
                    true,
                    '{"name":"romand"}',
                    '?name<br>
                    - Select a user by his name<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List a user by first name',
                    'user/list',
                    true,
                    '{"first_name":"alexis"}',
                    '?first_name<br>
                    - Select a user by his first name<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List a user by his mail',
                    'user/list',
                    true,
                    '{"email":"alexis.romand@etu.univ-grenoble-alpes.fr"}',
                    '?email<br>
                    - Select a user by his mail<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List a user by his login',
                    'user/list',
                    true,
                    '{"login":"romand"}',
                    '?login<br>
                        - Select a user by his login<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('List all the class of a user',
                    'user/list',
                    true,
                    '{"login":"romanda","allclass":"true"}',
                    '?login & ?allclass(BOOL)<br>
                        - Select all class from a User<br>',
                    '{"status":"true", ... , "data":[...]}');

                ?>

            </details>
            <?php echoAPIDoc('User:add',
                'user/add',
                true,
                '{"login":"alexislamoule","name":"romand","first_name":"alexis","email":"alexis@mail.fr","id_role":1}',
                '?login, ?name, ?first_name, ?email, ?id_role',
                '{"status":"true", ... , "data":[...]}');?>

            <details id="doc-${docid}">
                <summary>USER : Update</summary>
                <?php echoAPIDoc('Update only one variable of a user',
                    'user/update',
                    true,
                    '{"login":"alexislamoule","name":"jul"}',
                    '?login, (?name), (?first_name), (?email), (?id_role)<br><br>',
                    '{"status":"true", ... , "data":[...]}');?>

                <?php echoAPIDoc('Update multiple variables of a user',
                    'user/update',
                    true,
                    '{"login":"alexislamoule","name":"julius","name_class":"S1B1","first_name":"sébastien"}',
                    '?login, (?name), (?first_name), (?email), (?id_role)<br><br>',
                    '{"status":"true", ... , "data":[...]}');?>
            </details>

            <?php echoAPIDoc('User:delete',
                'user/delete',
                true,
                '{"login":"alexislamoule"}',
                '?login',
                '{"status":"true", ... , "data":[...]}'); ?>
        </details>

        <details id="doc-${docid}">
            <summary>USER_CLASS</summary>
            <?php
            echoAPIDoc('User_CLass:add',
                'user_class/add',
                true,
                '{"login":"alexislamoule","id_class":5}',
                '?login, ?id_class',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('User_CLass:update',
                'user_class/update',
                true,
                '{"login":"alexislamoule","id_class":3}',
                '?login, ?id_class',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('User_CLass:delete',
                'user_class/delete',
                true,
                '{"login":"alexislamoule","id_class":3}',
                '?login, ?id_class',
                '{"status":"true", ... , "data":[...]}');?>
        </details>

        <details id="doc-${docid}">
            <summary>CLASS</summary>
            <section>
                <details id="doc-${docid}">
                    <summary>CLASS : List</summary>
                    <?php
                    echoAPIDoc('All the listing possible',
                        'class/list',
                        true,
                        '{}',
                        '(?id_class), (?name_class), (?semester) <br>
                        - Select all classes<br>
                        - Select a class by his id<br>
                        - Select a class by his name<br>
                        - Select all classes from a semester (only write the number)',
                        '{"status":"true", ... , "data":[...]}');

                    echoAPIDoc('List every classes',
                        'class/list',
                        true,
                        '{}',
                        '- Select all classes',
                        '{"status":"true", ... , "data":[...]}');

                    echoAPIDoc('Select a class by his id',
                        'class/list',
                        true,
                        '{"id_class":3}',
                        '?id_class<br>
                - Select a class by his id<br>',
                        '{"status":"true", ... , "data":[...]}');

                    echoAPIDoc('Select a class by his name',
                        'class/list',
                        true,
                        '{"name_class":"S2B1"}',
                        '?name_class<br>
                    - Select a class by his name<br>',
                        '{"status":"true", ... , "data":[...]}');

                    echoAPIDoc('List all classes from a semester',
                        'class/list',
                        true,
                        '{"semester":2}',
                        '?semester<br>
                    - List all classes from a semester<br>',
                        '{"status":"true", ... , "data":[...]}');
                    ?>
                </details>

                <?php
                echoAPIDoc('Class:add',
                    'class/add',
                    true,
                    '{"name_class":"S5dev1"}',
                    ' ?name_class',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('Class:update',
                    'class/update',
                    true,
                    '{"id_class":2,"name_class":"Semestre1A2"}',
                    '?id_class, ?name_class',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('Class:delete',
                    'class/delete',
                    true,
                    '{"id_class":2}',
                    '?id_class',
                    '{"status":"true", ... , "data":[...]}');
                ?>
        </details>

        <details id="doc-${docid}">
            <summary>PROBLEM</summary>
            <details id="doc-${docid}">
                <summary>PROBLEM : List</summary>
                <?php
                echoAPIDoc('All the listing possible',
                    'problem/list',
                    true,
                    '{}',
                    '(?id_problem), (?id_material), (?id_res), (?login), (?problem_desc)<br>
                                - Select all problems<br>
                                - Select all problems linked to a material<br>
                                - Select all problems linked to a reservation<br>
                                - Select all problems linked to a user<br>
                                ((- Select all problems between a date X and Y))<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('Select all problems',
                    'problem/list',
                    true,
                    '{}',
                    '',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('Select all problems linked to a material',
                    'problem/list',
                    true,
                    '{"id_material"=2}',
                    '?id_material<br>
                                - Select all problems linked to a material<br>',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('Select all problems linked to a reservation',
                    'problem/list',
                    true,
                    '{"id_res":3}',
                    '?id_res<br>
                                - Select all problems linked to a reservation',
                    '{"status":"true", ... , "data":[...]}');

                echoAPIDoc('Select all problems linked to a user',
                    'problem/list',
                    true,
                    '{"login":"romand"}',
                    '?login<br>
                                - Select all problems linked to a user',
                    '{"status":"true", ... , "data":[...]}');


                ?>
            </details>

            <?php

            echoAPIDoc('Problem:add',
                'problem/add',
                true,
                '{"login":"simonlis","problem_desc"="A rendu en retard"}',
                '(?id_material), (?id_res), (?login), ?problem_desc<br>
                        - au moins un id est nécéssaire (res, mat ou log)',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Problem:update',
                'problem/update',
                true,
                '{"id_problem":3,"id_res":8,"problem_desc":"retard"}',
                '?id_problem, (?id_material), (?id_res), (?login), (?problem_desc)',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Problem:delete',
                'problem/delete',
                true,
                '{"id_problem":5}',
                '?id_problem',
                '{"status":"true", ... , "data":[...]}');
            ?>
        </details>

        <details id="doc-${docid}">
            <summary>MEMBER</summary>
            <?php
            echoAPIDoc('Member:list',
                'member/list',
                true,
                '{"id_res" : 7}',
                '?id_res<br>
                            - Select all members from a reservation<br>',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Member:add',
                'member/add',
                true,
                '{"id_res" : 7, "login" : "simonlis"}',
                '?id_res, ?login',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Member:delete',
                'member/delete',
                true,
                '{"id_res" : 7, "login" : "simonlis"}',
                '?id_res, ?login',
                '{"status":"true", ... , "data":[...]}');?>
        </details>

        <details id="doc-${docid}">
            <summary>ROOM</summary>
            <?php
            echoAPIDoc('Room:list',
                'room/list',
                true,
                '{"id_room" : 1}',
                '(?id_room)<br>
                               - Select all room
                               - Select a room by id',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Room:add',
                'room/add',
                true,
                '{"name_room" : "Super Room"}',
                '?name_room',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Room:update',
                'room/update',
                true,
                '{"id_room" : 2, "name_room" : "AHAHA Room"}',
                '?id_room, ?name_room',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Room:delete',
                'room/delete',
                true,
                '{"id_room" : 2}',
                '?id_room',
                '{"status":"true", ... , "data":[...]}');?>
        </details>

        <details id="doc-${docid}">
            <summary>RESERVATION</summary>
            <?php echoAPIDoc('Reservation:list',
                'reservation/list',
                true,
                '{"login":"lamande", "late":"true"}',
                '(?id_res), (?login), (?id_status), (?res_tp), (?id_material), (?member) (?date_begin), (?date_end), (?date_return), (?today BOOL), (?back BOOL), (?now BOOL), (?late BOOL) <br>
                                 - Select all reservation<br>
                                - Select all reservation from a user (?login)<br>
                                - Select all reservations where a certain user is at least a member (?member)<br>
                                - Select all reservations containing a certain material (?id_material)<br>
                                - Select all reservation having the same status (wishlist, waiting, validated) (?id_status)<br>
                                - Select all reservations who are for a TP (?res_tp)<br>
                                - Select all reservations to give today (?today BOOL)<br>
                                - Select all reservations to get back today (?back BOOL)<br>
                                - Select all reservations returned at a certain date (?date_return)<br>
                                - Select all reservations beginning at date X (?date_begin)<br>
                                - Select all reservations ending at date X (?date_end)<br>
                                - Select all reservations between a date X and Y (?date_begin&date_end)<br>
                                - Select all lates reservation (?late BOOL)<br>
                                - Select all currents reservations (?now BOOL)<br>
                                - Order by date (?orderby)<br>
                                '
                ,

                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Reservation:add',
                'reservation/add',
                true,
                '{"login" :  "hafraoui"}',
                '?login, (?id_class) <br>
                       - Créé une reservation au nom de login<br>
                       - Si id_class est renseigné, créé une reservation pour un cours ',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Reservation:update',
                'reservation/update',
                true,
                '{"id_res" : 7, "id_status" : 3}',
                '?id_res, (?id_status), (?id_class)',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Reservation:delete',
                'reservation/delete',
                true,
                '{"id_res" : 7}',
                '?id_res',
                '{"status":"true", ... , "data":[...]}');?>
        </details>

        <details id="doc-${docid}">
            <summary>MATERIAL</summary>
            <?php echoAPIDoc('Material:list',
                'material/list',
                true,
                '{"date_begin" : "2019-08-20 10:22:34" ,"date_end": "2019-08-20 10:22:34", "obsolete" : 0}',
                '(?id_material), (?id_model), (?number), (?date_add), (?id_room), (?obsolete), (?in_repair), (?date_begin), (?date_end) , (?id_res) , (?late_now) , (?was_late)<br><br>
            - Select all materials<br>
            - Select material by his id<br>
            - Select all materials from a certain model<br>
            - Select all materials from a certain category<br>
            - Select a specific material by his number and his model<br>
            - Select all materials form a certain room<br>
            - Select all materials obsoletes<br>
            - Select all materials to repair<br>
            - Select materials available between date X and date Y<br>
            - Select all materials from a reservation<br>
            - Select all materials from a reservation that is for a tp<br>
            - Select all materials that is late right now<br>
            - Select all materials has been late<br>
            - Select all materials from a reservation that is for a tp
            ',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Material:add',
                'material/add',
                true,
                '{"id_model" : 2 , "date" : '.date("yyyy-mm-dd").', "obsolete" : 0, "in_repair" : 0}',
                '?id_model, (?description), ?date, (?id_room), ?obsolete, ?in_repair',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Material:update',
                'material/update',
                true,
                '{"id_material" : 4 ,"id_room" : 1 , "obsolete" : 1}',
                '?id_material, (?id_model), (?number), (?description_material), (?date_add), (?id_room), (?obsolete), (?in_repair)',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Material:delete',
                'material/delete',
                true,
                '{"id_material" : 4 }',
                '?id_material',
                '{"status":"true", ... , "data":[...]}');?>
        </details>

        <details id="doc-${docid}">
            <summary>MODEL</summary>
            <?php

            echoAPIDoc('Model:list',
                'cart/list',
                true,
                '{"id_type" : 1}',
                '(?id_model), (?name_model), (?id_type)<br>
            - Select all model<br>
            - Select model by his id<br>
            - Select all materials from a certain type<br>',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Model:add',
                'model/add',
                true,
                '{"id_model" : 4 ,"name_model" : "Nieme Canon" , "desc_model" : "la toute derniere canon" , "id_type" : 1}',
                '?id_model, ?name_model, ?desc_model, ?image, ?id_type',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Model:update',
                'model/update',
                true,
                '{"id_model" : 4 ,"name_model" : "Lumix" , "id_type" : 3}',
                '?id_model, (?name_model), (?description), (?image), (id_type)',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Model:delete',
                'model/delete',
                true,
                '{"id_model" : 4 }',
                '?id_model',
                '{"status":"true", ... , "data":[...]}');?>
        </details>

        <details id="doc-${docid}">
            <summary>CART</summary>
            <?php
            echoAPIDoc('Cart:list',
                'cart/list',
                true,
                '{"id_material" : 4}',
                '(?id_material), (?id_res)<br>
            - Select all cart<br>
            - Select all from cart, specific material<br>
            - Select all from cart, specific reservation<br>',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Cart:add',
                'cart/add',
                true,
                '{"id_res" : 8 , "date_begin" : "2023-06-18 10:15:00" , "date_end" : "2023-06-18 12:15:00" , "id_room" : 1}',
                '?id_res, ?date_end, ?date_begin, ?id_room OR ?id_material',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Cart:update',
                'cart/update',
                true,
                '{"id_res" : 8 ,"id_room" : 1 , "date_return" : "2023-06-18 12:15:00"}',
                '?id_material OR ?id_room, ?id_res, (?date_return), (?date_begin), (?date_end)',
                '{"status":"true", ... , "data":[...]}');

            echoAPIDoc('Cart:delete',
                'cart/delete',
                true,
                '{"id_res" : 8 ,"id_room" : 1  }',
                '?id_res, ?id_material OR ?id_room',
                '{"status":"true", ... , "data":[...]}');
            ?>
        </details>
    </details>
</section>
