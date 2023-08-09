<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выбор размера");

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<main>

<article class="container pt-7 mt-1 pb-10 mb-4  text">
    <h1 class="h1 mb-lg-4 mb-5"><?=Loc::getMessage('CHOOSING_SIZE_TITLE');?></h1>
    <p class="mb-lg-6 mb-8"><strong class="text-dark"><?=Loc::getMessage('SIZE_OF_CLOTHES_DESCRIPTION');?></strong></p>
    <h3 class="text-dark fs-lg-3 fs-5"><?=Loc::getMessage('ITEM_SIZE');?>.</h3>
    <p class="mb-lg-8 mb-6"><?=Loc::getMessage('SIZE_OF_CLOTHES_DESCRIPTION');?>.</p>

    <p class="mb-lg-7 mb-0"><strong class="text-dark"><?=Loc::getMessage('SPECIAL_ATTENTION');?>:</strong></p>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include", 
        ".default", 
        array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_TEMPLATE" => "",
            "COMPONENT_TEMPLATE" => ".default",
            "PATH" => "/include/special_attention_sizes.php"
        ),
        false
    );?>
    
    <h3 class="text-dark fs-lg-3 fs-5 mb-lg-7 mb-6"><?=Loc::getMessage('SHOES_SIZE');?>.</h3>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include", 
        ".default", 
        array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_TEMPLATE" => "",
            "COMPONENT_TEMPLATE" => ".default",
            "PATH" => "/include/shoes_sizes.php"
        ),
        false
    );?>

    <div class="py-lg-6 py-4 mb-4 pb-2 text-dark">
        <p class="fw-bold  fs-5 mb-lg-4 mb-2"><?=Loc::getMessage('TABLE_1_DESCRIPTION');?></p>
        
        <div class="d-sm-none d-flex justify-content-center">
            <img src="assets/img/select-size/table-1.png" alt="" class="img">
        </div>

        <div class="d-none d-sm-block">
            <table width="100%" class="fs-5 text-dark">
                <tbody>
                    <tr>
                        <th class="text-dark"><?=Loc::getMessage('RUSSIA');?></th>
                        <td>46-48</td>
                        <td>48-50</td>
                        <td>50-52</td>
                        <td>52-54</td>
                        <td>54-56</td>
                        <td>56-58</td>
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('INTERNATIONAL');?></th>
                        <td>S</td>
                        <td>M</td>
                        <td>L</td>
                        <td>XL</td>
                        <td>XXL</td>
                        <td>XXXL</td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('CHINA');?></th>
                        <td>S-M</td>
                        <td>M-L</td>
                        <td>L-XL</td>
                        <td>XL-XXL</td>
                        <td>XXL</td>
                        <td></td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('CHEST_GIRTH');?></th>
                        <td>92</td>
                        <td>96</td>
                        <td>100</td>
                        <td>104</td>
                        <td>108</td>
                        <td></td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('WAIST_GIRTH');?></th>
                        <td>80</td>
                        <td>84</td>
                        <td>88</td>
                        <td>92</td>
                        <td>96</td>
                        <td></td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('NECK_GIRTH');?></th>
                        <td>39</td>
                        <td>40-41</td>
                        <td>41-42</td>
                        <td>42-43</td>
                        <td>43-44</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('HEIGHT');?></th>
                        <td>164-170</td>
                        <td>170-176</td>
                        <td>176-182</td>
                        <td>182-188</td>
                        <td>188 ></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>

    <div class="py-lg-6 py-4 pb-2 text-dark">
        <p class="fw-bold fs-5 mb-2 mb-lg-4"><?=Loc::getMessage('TABLE_2_DESCRIPTION');?></p>
        <div class="d-sm-none d-flex justify-content-center">
            <img src="assets/img/select-size/table-2.png" alt="" class="img">
        </div>
        <div class="d-none d-sm-block">
            <table width="100%" class="fs-5 text-dark">
                <tbody>
                    <tr>
                        <th class="text-dark"><?=Loc::getMessage('RUSSIA');?></th>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                        <td>58</td>
                        
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('INTERNATIONAL');?></th>
                        <td>XS</td>
                        <td>XS</td>
                        <td>S</td>
                        <td>M</td>
                        <td>M</td>
                        <td>L</td>
                        <td>XL</td>
                        <td>XL</td>
                        <td>XXL</td>
                        <td>XXXL</td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('CHINA');?></th>
                        
                        <td></td>
                        <td></td>

                        <td>S</td>
                        <td>M</td>
                        <td>M</td>
                        <td>L</td>
                        <td>L</td>
                        <td>XL</td>
                        <td>XL</td>
                        <td>XXL</td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('CHEST_GIRTH');?></th>
                        <td></td>
                        <td></td>

                        <td>88</td>
                        <td>92</td>
                        <td>96</td>
                        <td>100</td>
                        <td>104</td>
                        <td>108</td>
                        <td>112</td>
                        <td>116</td>
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('HIPS_GIRTH');?></th>
                        <td></td>
                        <td></td>

                        <td>96</td>
                        <td>100</td>
                        <td>104</td>
                        <td>108</td>
                        <td>112</td>
                        <td>116</td>
                        <td>120</td>
                        <td>124</td>
                        
                    </tr>

                    <tr>
                        <th><?=Loc::getMessage('HEIGHT');?></th>
                        <td></td>
                        <td></td>

                        <td> &lt; 164</td>
                        <td>164 -</td>
                        <td>170</td>
                        <td>170 -</td>
                        <td>176</td>
                        <td>176 -</td>
                        <td>182</td>
                        <td>182 &gt;</td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="py-lg-6 py-4 pb-2 text-dark">
        <p class="fw-bold fs-5 mb-2 mb-lg-4"><?=Loc::getMessage('TABLE_3_DESCRIPTION');?></p>
        <div class="d-sm-none d-flex justify-content-center">
            <img src="assets/img/select-size/table-3.png" alt="" class="img">
        </div>
        <div class="d-none d-sm-block">
            <table width="100%" class="fs-5 text-dark">
                <tbody>
                    <tr>
                        <th><?=Loc::getMessage('CM');?>.</th>
                        <td>25</td>
                        <td>25,5</td>
                        <td>26</td>
                        <td>26,5</td>
                        <td>27</td>
                        <td>27,5</td>
                        <td>28</td>
                        <td>28,5</td>
                        <td>29</td>
                        <td>29,5</td>
                        <td>30</td>
                        <td>31</td>
                        <td>32</td>
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('RUSSIA');?></th>
                        <td>39</td>
                        <td>39,5</td>
                        <td>40</td>
                        <td>40,5</td>
                        <td>41</td>
                        <td>41,5</td>
                        <td>42</td>
                        <td>42,5</td>
                        <td>43</td>
                        <td>43,5</td>                        
                        <td>44</td>
                        <td>45</td>
                        <td>46</td>
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('CHINA');?></th>
                        <td>38,5</td>
                        <td>39</td>
                        <td>39,5</td>
                        <td>40</td>
                        <td>41</td>
                        <td>42</td>
                        <td>43</td>
                        <td>44</td>
                        <td>45</td>
                        <td>46</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="py-lg-6 py-4 pb-2 text-dark mb-6">
        <p class="fw-bold fs-5 mb-2 mb-lg-4"><?=Loc::getMessage('TABLE_4_DESCRIPTION');?></p>
        <div class="d-sm-none d-flex justify-content-center">
            <img src="assets/img/select-size/table-4.png" alt="" class="img">
        </div>
        <div class="d-none d-sm-block">
            <table width="100%" class="fs-5 text-dark">
                <tbody>
                    <tr>
                        <th><?=Loc::getMessage('CM');?>.</th>
                        
                        <td>21,5</td>
                        <td>22</td>
                        <td>22,5</td>
                        <td>23</td>
                        <td>23,5</td>
                        <td>24</td>
                        <td>24,5</td>
                        <td>25</td>
                        <td>25,5</td>
                        <td>26</td>
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('RUSSIA');?></th>
                        <td>35</td>
                        <td>35,5</td>
                        <td>36</td>
                        <td>36,5</td>
                        <td>37</td>
                        <td>37,5</td>
                        <td>38</td>
                        <td>38,5</td>
                        <td>39</td>
                        <td>39,5</td>
                    </tr>
                    <tr>
                        <th><?=Loc::getMessage('CHINA');?></th>
                        <td>34</td>
                        <td>34</td>
                        <td>35</td>
                        <td>35</td>
                        <td>36-37</td>
                        <td>37-38</td>
                        <td>38</td>
                        <td>38-39</td>
                        <td>39-40</td>
                        <td>40</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include", 
        ".default", 
        array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_TEMPLATE" => "",
            "COMPONENT_TEMPLATE" => ".default",
            "PATH" => "/include/attention_big_sizes.php"
        ),
        false
    );?>
    
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include", 
        ".default", 
        array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "AREA_FILE_RECURSIVE" => "Y",
            "EDIT_TEMPLATE" => "",
            "COMPONENT_TEMPLATE" => ".default",
            "PATH" => "/include/bottom_text_sizes.php"
        ),
        false
    );?>
    
</article>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
