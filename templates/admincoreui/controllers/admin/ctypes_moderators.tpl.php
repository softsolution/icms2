<?php

    $this->addTplJSName('admin-moderators');

    $this->setPageTitle(LANG_MODERATORS, $ctype['title']);

    $this->addBreadcrumb(LANG_CP_SECTION_CTYPES, $this->href_to('ctypes'));
    $this->addBreadcrumb($ctype['title'], $this->href_to('ctypes', array('edit', $ctype['id'])));
    $this->addBreadcrumb(LANG_MODERATORS);

    $this->addMenuItems('admin_toolbar', $this->controller->getCtypeMenu('moderators', $ctype['id']));

	$this->addToolButton(array(
		'class'  => 'settings',
        'title'  => LANG_MODERATORATION_OPTIONS,
        'href'   => href_to('admin', 'controllers', array('edit', 'moderation', 'options'))
    ));

	$this->addToolButton(array(
		'class'  => 'help',
        'title'  => LANG_HELP,
        'target' => '_blank',
        'href'   => LANG_HELP_URL_CTYPES_MODERATORS
    ));

?>

<nav class="cp_toolbar navbar navbar-light bg-light my-3 py-1">
    <?php $this->toolbar(); ?>
</nav>

<div id="ctype_moderators_list" class="striped-list list-32" <?php if (!$moderators){ ?>style="display:none"<?php } ?>>

    <div class="datagrid_wrapper">
        <table id="datagrid" class="datagrid table table-striped table-bordered table-hover table-light" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="2"><?php echo LANG_MODERATOR; ?></th>
                    <th class="center"><?php echo LANG_MODERATOR_ASSIGNED_DATE; ?></th>
                    <th class="center"><?php echo LANG_MODERATOR_TRASH_LEFT_TIME; ?></th>
                    <th class="center"><?php echo LANG_MODERATOR_APPROVED_COUNT; ?></th>
                    <th class="center"><?php echo LANG_MODERATOR_DELETED_COUNT; ?></th>
                    <th class="center"><?php echo LANG_MODERATOR_IDLE_COUNT; ?></th>
                    <th class="center" width="32"><?php echo LANG_CP_ACTIONS; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($moderators){ ?>
                    <?php foreach($moderators as $moderator) { ?>
                        <?php echo $this->renderChild('ctypes_moderator', array('moderator'=>$moderator, 'ctype'=>$ctype)); ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<div id="ctype_moderators_add" class="gui-panel">

    <h3><?php echo LANG_MODERATOR_ADD; ?></h3>
    <div class="hint"><?php echo LANG_MODERATOR_ADD_HINT; ?></div>

    <div class="field">
        <?php echo html_input('text', 'user_email', '', array('id'=>'user_email', 'autocomplete'=>'off')); ?>
        <?php echo html_button(LANG_ADD, 'add', 'return icms.adminModerators.add()', array('id'=>'submit', 'disabled'=>'disabled')); ?>
    </div>
    <div class="loading-icon" style="display:none"></div>

</div>

<script>

    $(document).ready(function(){

        icms.adminModerators.url_submit = '<?php echo $this->href_to('ctypes', array('moderators', $ctype['id'],  'add')); ?>';
        icms.adminModerators.url_delete = '<?php echo $this->href_to('ctypes', array('moderators', $ctype['id'],  'delete')); ?>';

        var cache = {};

        $( "#user_email" ).autocomplete({
            minLength: 2,
            delay: 500,
            source: function( request, response ) {

                var term = request.term;

                if ( term in cache ) {
                    response( cache[ term ] );
                    return;
                }

                $.getJSON('<?php echo $this->href_to('users', 'autocomplete'); ?>', request, function( data, status, xhr ) {
                    cache[ term ] = data;
                    response( data );
                });

            }
        });

        $( "#submit" ).prop('disabled', false);
        $('#ctype_moderators_list #datagrid tr:odd').addClass('odd');

    });

</script>