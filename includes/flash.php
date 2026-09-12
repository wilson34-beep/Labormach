<?php foreach (flashes() as $item): ?>
  <div class="alert <?= e($item['type']) ?>"><?= e($item['message']) ?></div>
<?php endforeach; ?>

