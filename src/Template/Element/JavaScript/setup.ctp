<?php
/**
 * @var \Wasabi\Core\View\AppView $this
 * @var int $heartBeatFrequency
 */

use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<?= $this->Asset->js('js/require.js', 'Wasabi/Core') ?>
<?php if (!Configure::read('debug')): ?>
<?= $this->Asset->js('js/common.js', 'Wasabi/Core') ?>
<?= $this->Asset->js('js/wasabi.js', 'Wasabi/Core') ?>
<?= $this->fetch('js-files') ?>
<?php endif; ?>
<script>
    <?php
    if (Configure::read('debug')): ?>
    require.config(<?= json_encode([
        'baseUrl' => Router::url('/wasabi_core/ASSETS/js'),
        'urlArgs' => 't=' . time()
    ]) ?>);
    require(['common'], function() {
    <?php endif; ?>
        require(['wasabi'], function(WS) {
            WS.registerModule('wasabi.core', {
                baseUrl: '<?= $this->Url->build('/backend', true) ?>',
                translations: {
                    confirmYes: '<?= __d('wasabi_core', 'Yes') ?>',
                    confirmNo: '<?= __d('wasabi_core', 'No') ?>'
                },
                heartbeat: <?= $heartBeatFrequency ?>,
                heartbeatEndpoint: '<?= $this->Url->build('/backend/heartbeat') ?>'
            });
<?= $this->fetch('requirejs') ?>
            WS.boot();
        });
    <?php if (Configure::read('debug')): ?>
    });
    <?php endif; ?>
</script>
