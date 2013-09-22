<ul class="nav nav-tabs">
    <li class="active">
        <a href="#status_<?php echo \core\tkr\Bug::STATUS_WAITING ?>">
            <strong><?php echo $ct = $res->countBugs() ?></strong>
            Bug<?php echo $ct > 1 ? 's' : '' ?> 
            (Total)
        </a>
    </li>
    <li>
        <a href="#status_<?php echo \core\tkr\Bug::STATUS_CLIENT_WAITING ?>">
            <strong><?php echo $ct = $res->countClientWaitingBugs() ?></strong>
            Bug<?php echo $ct > 1 ? 's' : '' ?> 
            en attente de réponse client
        </a>
    </li>
    <li>
        <a href="#status_<?php echo \core\tkr\Bug::STATUS_ASSIGNED ?>">
            <strong><?php echo $ct = $res->countAssignedBugs() ?></strong>
            Bug<?php echo $ct > 1 ? 's' : '' ?> 
            en cours de résolution
        </a>
    </li>
    <li>
        <a href="#status_<?php echo \core\tkr\Bug::STATUS_WAITING ?>">
            <strong><?php echo $ct = $res->countUnassignedBugs() ?></strong>
            Bug<?php echo $ct > 1 ? 's' : '' ?> non 
            assigné<?php echo $ct > 1 ? 's' : '' ?> 
        </a>
    </li>
    <li>
        <a href="#status_<?php echo \core\tkr\Bug::STATUS_FIXED ?>">
            <strong><?php echo $ct = $res->countFixedBugs() ?></strong>
            Bug<?php echo $ct > 1 ? 's' : '' ?> 
            résolu<?php echo $ct > 1 ? 's' : '' ?>
        </a>
    </li>
    <li>
        <a href="#status_<?php echo \core\tkr\Bug::STATUS_ABORTED ?>">
            <strong><?php echo $ct = $res->countAbortedBugs() ?></strong>
            Bug<?php echo $ct > 1 ? 's' : '' ?> 
            abandonné<?php echo $ct > 1 ? 's' : '' ?>
        </a>
    </li>
</ul>