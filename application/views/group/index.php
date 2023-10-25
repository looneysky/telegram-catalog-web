<?php
$id = $_GET['id'];
$group = getGroupById($id);
?>
<div id="content">
    <div class="container">
        <div class="tg-channels is-detail">
            <div class="tg-channel-wrapper is-detail">
                <div class="tg-channel">
                    <div class="tg-channel-options"><span class="tg-options-public">публичный</span></div>
                    <div class="tg-channel-img"><img
                            src="<? echo $group['avatar'] ?>"
                            alt="Telegram Tips" loading="lazy"></div>
                    <div class="tg-channel-link" title="Telegram Tips">
                        <h1 class="tg-channel-header"><a href="<? echo $group['url'] ?>"
                                target="_blank"><? echo $group['name'] ?></a></h1>
                    </div>
                    <div class="tg-channel-user"><i class="fa-solid fa-user"></i><span
                            class="tg-user-count"><? echo $group['subs'] ?></span>
                    </div>
                    <div class="tg-channel-description"
                        title="Telegram stands for freedom and privacy and has many easy to use features."><? echo $group['description'] ?></div>
                    <div class="tg-channel-more"><a class="app" href="<? echo $group['url'] ?>" target="_blank" title="Открыть в Telegram">Открыть
<i class="fa-brands fa-telegram" style="left: 5px;"></i></a></div>
                    <div class="tg-channel-categories"><a href="/category.php?name=<? echo str_replace('#', '', $group['category']); ?>
"><? echo $group['category'] ?></a></div>
                </div>
<h3>Похожие каналы</h3>
<? $groups = getGroupsByCategoryExcludingId($group['category'], $group['id']); ?>
<div class="tg-channels is-list">
    <? foreach ($groups as $group) { ?>
        <div class="tg-channel-wrapper is-list" style="margin-top: 5px;">
        <div class="tg-channel">
            <div class="tg-channel-options"><span class="tg-options-public">публичный</span></div>
            <div class="tg-onclick">
                <div class="tg-channel-img"><img
                        src="<? echo $group['avatar'] ?>"
                        alt="<? echo $group['name'] ?>" loading="lazy"></div>
                <div class="tg-channel-link" title="<? echo $group['name'] ?>"><a href="/group.php?id=<? echo $group['id'] ?>"><? echo $group['name'] ?></a></div>
                <div class="tg-channel-user"><i class="fa-solid fa-user"></i><span
                        class="tg-user-count"><? echo $group['subs'] ?></span></div>
                <div class="tg-channel-description"
                    title="<? echo $group['description'] ?>">
                    <?php
$description = $group['description'];
$maxChars = 100;

if (mb_strlen($description, 'UTF-8') > $maxChars) {
    $description = mb_substr($description, 0, $maxChars, 'UTF-8') . '...';
}

echo $description;
?></div>
            </div>
            <div class="tg-channel-categories"><a href="/category.php?name=<? echo str_replace('#', '', $group['category']); ?>"><? echo $group['category'] ?></a></div>
        </div>
    </div>
    <? } ?>
    </div>
    </div>
        </div>
    