<?php
$query = $_GET['query'];
// Определите текущую страницу из параметра запроса, например, $_GET['page']
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$groups_per_page = 29; // Количество групп на одной странице

// Получите группы для текущей страницы
$start_index = ($current_page - 1) * $groups_per_page;
$end_index = $start_index + $groups_per_page - 1;
$groups = getGroupsBySearch($query,$start_index, $end_index);

?>
<div id="content">
            <div class="container"><input id="hnt-ct" class="hidden-ticker-ct" type="checkbox" style="display:none;">
                <h1>Каталог телеграм каналов</h1>
                <div class="tg-channels is-list">
                    <? foreach($groups as $group) { ?>
                    <div class="tg-channel-wrapper is-list">
                        <div class="tg-channel">
                            <div class="tg-channel-options"><span class="tg-options-public">публичный</span></div>
                            <div class="tg-onclick">
                                <div class="tg-channel-img"><img src="<? echo $group['avatar'] ?>" alt="<? echo $group['name'] ?>" loading="lazy"></div>
                                <div class="tg-channel-link" title="<? echo $group['name'] ?>"><a href="/group.php?id=<? echo $group['id'] ?>"><? echo $group['name'] ?></a></div>
                                <div class="tg-channel-user"><i class="fa-solid fa-user"></i><span class="tg-user-count"><? echo $group['subs'] ?></span></div>
                                <div class="tg-channel-description" title="<? echo $group['description'] ?>"><? echo $group['description'] ?></div>
                            </div>
                            <div class="tg-channel-categories"><a href="/category.php?name=<? echo str_replace('#', '', $group['category']); ?>
"><? echo $group['category'] ?></a></div>
                        </div>
                    </div>
                    <? } ?>
                    <div class="tg-pager-wrapper">
                        <ul class="tg-pager">
                        <?php for ($i = 1; $i <= ceil(countGroupsBySearch($query) / $groups_per_page); $i++) { ?>
                            <li class="tg-pager-li <?php echo ($i == $current_page) ? 'is-current' : ''; ?>">
                                <a href="/index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div><input id="hnt-ad" class="hidden-ticker-ad" type="checkbox" style="display:none;">
                
                
            </div>
        </div>