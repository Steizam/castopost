<?php
// Show total from API separately if we have it
$totalPublished = count($episodes);
?>
<div class="page-head fade">
  <h1>Episodios</h1>
  <p><?= $totalPublished ?> publicados en <strong><?= htmlspecialchars($activePodcast) ?></strong></p>
</div>

<?php if (defined('CASTOPOD_DEBUG') && CASTOPOD_DEBUG && !empty($episodes)): ?>
<details style="margin-bottom:1rem;font-size:.7rem;color:var(--text3)">
  <summary style="cursor:pointer">Debug: campos del primer episodio</summary>
  <pre style="overflow:auto;padding:.6rem;background:var(--bg2);border-radius:6px;margin-top:.4rem;font-family:'Noto Sans Mono',monospace"><?= htmlspecialchars(json_encode($episodes[0], JSON_PRETTY_PRINT)) ?></pre>
</details>
<?php endif; ?>

<?php if (!empty($episodes)): ?>
<div class="ep-list fade">
  <?php foreach ($episodes as $i => $ep):
    $ts  = !empty($ep['published_at']) && strtotime($ep['published_at']) ? strtotime($ep['published_at']) : null;
    $num = $ep['number'] ?? $ep['episode_number'] ?? null;
    // title comes directly from Episode entity serialization
    $ttl = $ep['title'] ?? null;
    $dur = !empty($ep['duration']) ? (int)$ep['duration'] : 0;
  ?>
  <div class="ep-item" style="animation-delay:<?= min($i, 20) * 0.02 ?>s">
    <span class="ep-num"><?= $num !== null ? htmlspecialchars((string)$num) : '-' ?></span>
    <div class="ep-info">
      <div class="ep-title">
        <?php if ($ttl): ?>
          <?= htmlspecialchars($ttl) ?>
        <?php else: ?>
          <em style="color:var(--text3);font-style:normal">ID <?= (int)($ep['id'] ?? 0) ?></em>
        <?php endif; ?>
      </div>
      <div class="ep-meta">
        <?= $ts ? date('d/m/Y', $ts) : '' ?>
        <?php if (!empty($ep['season_number'])): ?>&middot; T<?= (int)$ep['season_number'] ?><?php endif; ?>
        <?php if ($dur > 0): ?>&middot; <?= $dur >= 3600 ? gmdate('H:i:s', $dur) : gmdate('i:s', $dur) ?><?php endif; ?>
      </div>
    </div>
    <?php if (!empty($ep['type']) && $ep['type'] !== 'full'): ?>
    <span class="ep-type"><?= htmlspecialchars($ep['type']) ?></span>
    <?php endif; ?>
    <?php if (!empty($ep['audio_url'])): ?>
    <a href="<?= htmlspecialchars($ep['audio_url']) ?>" target="_blank" class="btn btn-ghost btn-sm" title="Escuchar">&#9654;</a>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
<div class="empty fade">
  <div class="empty-icon">&#127911;</div>
  <p>No hay episodios publicados.</p>
  <a href="index.php?page=publish&podcast=<?= urlencode($activePodcast) ?>" class="btn btn-ghost btn-sm">Publicar el primero</a>
</div>
<?php endif; ?>

<div style="margin-top:1.25rem;text-align:right">
  <a href="index.php?page=publish&podcast=<?= urlencode($activePodcast) ?>" class="btn btn-primary btn-sm">+ Nuevo episodio</a>
</div>
