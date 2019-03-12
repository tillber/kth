# shunt.ex
defmodule Shunt do

  def find(xs, [hy|ty]) do
    {x, y} = split(xs, hy)
    find(xs, hy, y)
  end
  def find([], [], []) do
    []
  end
  def find([h|t], [], []) do
    [{:two, 1}] ++ find(t, [], []) ++ [{:one, -1}]
  end
  def find(x, [], [h|t]) do
    [{:one, 1}] ++ find(x, [], t) ++ [{:two, -1}]
  end
  def find(x, hy, []) do
    [{:one, 1}] ++ find(x, [], []) ++ [{:two, -1}]
  end
  def find([h|t], hy, y) do
    case h do
      hy ->
        find(t, y)
      _ ->
        {x, y} = split([h|t], hy)
        [{:one, 1}] ++ find(x, [], y) ++ [{:two, -1}]
    end
  end

  # if e is member of x -> move to track one
  # if e is member of y -> move to track two
  # when main is empty, start moving back till x is empty, then start moving back y

  def split(list, y) do
    split(list, list, y)
  end
  def split([y|_], list, y) do
    {ListP.take(list, ListP.position(list, y) - 1), ListP.drop(list, ListP.position(list, y))}
  end
  def split([_|t], list, y) do
    split(t, list, y)
  end
end
