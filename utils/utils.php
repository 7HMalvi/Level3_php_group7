<?php
function containsId($arrayOfAssociativeArrays, $idToFind) {
    foreach ($arrayOfAssociativeArrays as $item) {
        if (isset($item['id']) && $item['id'] === $idToFind) {
            return true;
        }
    }
    return false;
}
