# test.ex
defmodule Test do
  def test do
    1 + 6
  end

  def seven([]) do [] end
  def seven([h|t]) do
    case h do
      229 -> [?{|seven(t)]
      228 -> [?}|seven(t)]
      246 -> [?||seven(t)]
      _ -> [h|seven(t)]
    end
  end

  @type tree :: {:node, integer(), tree, tree} | nil
  def traverse(nil) do [] end
  def traverse({:node, value, left, right}) do
    traverse(left) ++ [value] ++ traverse(right)
  end

  def better(nil) do [] end
  def better(list) do
    traverse(list, [])
  end

  def traverse(nil, list) do list end
  def traverse({:node, value, left, right}, list) do
    traverse(left, [value|traverse(right, list)])
  end

  @spec insert(tree, integer()) :: tree
  #def insert(nil, value) do {:node, value, nil, nil} end
  #def insert({:node, value, left, right}, insert_val) do
  #  cond do
  #    insert_val < value ->
  #      {:node, value, insert(left, insert_val), right}
  #    insert_val > value ->
  #      {:node, value, left, insert(right, insert_val)}
  #    insert_val == value ->
  #      {:node, insert_val, left, insert(right, value)}
  #  end
  #end

  def sound(c) do
    if Enum.member?([97, 101, 105, 111, 121, 229, 228, 246], c) do
      :vowel
    else
      :cons
    end
  end

  def rovare([]) do [] end
  def rovare([32|t]) do
    [32|rovare(t)]
  end
  def rovare([h|t]) do
    case sound(h) do
      :vowel ->
        [h|rovare(t)]
      :cons ->
        [h, 111, h] ++ rovare(t)

    end
  end


  def insert(nil, value) do {:node, value, nil, nil} end
  def insert({node, val, left, right}, value) do
    cond do
      value < val ->
        {:node, val, insert(left, value), right}
      value > val ->
        {:node, value, insert(left, val), right}
    end
  end
end
