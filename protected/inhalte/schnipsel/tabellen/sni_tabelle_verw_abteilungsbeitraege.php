<table>
  <colgroup width="26" span="2" />


  <thead>
    <tr>
      <th colspan="2">&nbsp;</th>
      <th>Bezeichnung</th>
      <th>Beitrag/Monat</th>
    </tr>
  </thead>
  <tbody>
  <?php
      foreach ($BeitraegeArray as $i => $Beitrag) {
          ?>
          <tr class="<?php echo ($i % 2) ? ('even') : ('odd') ?>">
              <td>
                  <button type="submit" class="icon" name="edit" value="<?php echo $Beitrag->getBeitragID() ?>">
                      <img src="bilder/buttons/b_edit.png" title="Bearbeiten" alt="Bearbeiten" width="16" height="16" />
                  </button>
              </td>
              <td>
                  <?php
                  if ($Beitrag->isDeletable()) {
                      ?>
                  <button type="submit" class="icon" name="drop" value="<?php echo $Beitrag->getBeitragID() ?>"
              onclick="return confirm('Den Beitrag \'<?php echo $Beitrag ?>\' wirklich löschen?')">
                      <img src="bilder/buttons/b_drop.png" title="Löschen" alt="Löschen" width="16" height="16" />
                  </button>
                  <?php

                  } else {
                      echo '&nbsp;';
                  } ?>
              </td>
              <td><?php echo $Beitrag->getBezeichnung() ?></td>
              <td><?php echo $Beitrag->getBeitrag() ?> €</td>
          </tr>
    <?php

      }
    ?>
  </tbody>
</table>
